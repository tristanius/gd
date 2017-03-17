<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('config');
		date_default_timezone_set("America/Bogota");
	}

	public function index(){
	}

	#======================================================================================
	#======================================================================================
	#Subir y registrar documento
	public function upload()
	{
		$gestion = $this->input->post('gestion');
		$this->crear_directorio($gestion);

		$folder = $this->input->post('folder');
		$folder = str_replace(" ", '', $folder);
		$this->crear_directorio($gestion."/".$folder);

		$tipo = $this->input->post('tipo');
		$tipo = str_replace(" ", '-', $tipo);
		$this->crear_directorio($gestion."/".$folder."/".$tipo);

		$nom = $this->input->post('nomdoc');
		$nom = str_replace(" ", '', $nom);

		/*
		
		#ver addMovimiento

		$this->load->library("encrypt");
		$base = $this->input->post("base");
		$user = $this->input->post("resu");
		$usuario = $this->encrypt->decode($user);
		*/

		# ruta PATHTOWWW/app/gd/uploads/gestion/folder/tipo/nombrearchivo-tipo.pdf
		$config = $this->configFile($nom, $gestion, $folder, $tipo); #linea 36
		$this->load->library('upload',$config);
		if($this->upload->do_upload('mydoc')){
			$data = $this->upload->data();
			echo $this->regDoc($data['file_name'], $gestion, $tipo, $folder, $base, $usuario);
		}else{
			print_r($this->upload->display_errors());;
		}
	}
	#devuelve el nombre del archivo en vez de su id
	public function upload2()
	{
		$gestion = $this->input->post('gestion');
		$this->crear_directorio($gestion);

		$folder = $this->input->post('folder');
		$folder = str_replace(" ", '', $folder);
		$this->crear_directorio($gestion."/".$folder);

		$tipo = $this->input->post('tipo');
		$tipo = str_replace(" ", '-', $tipo);
		$this->crear_directorio($gestion."/".$folder."/".$tipo);

		$nom = $this->input->post('nomdoc');
		$nom = str_replace(" ", '', $nom);
		# ruta PATHTOWWW/app/gd/uploads/gestion/folder/tipo/nombrearchivo-tipo.pdf
		$config = $this->configFile($nom, $gestion, $folder, $tipo); #linea 36
		$this->load->library('upload',$config);
		if($this->upload->do_upload('mydoc')){
			$data = $this->upload->data();
			echo $data['file_name'];
		}else{
			echo false;
		}
	}

	public function configFile($nom, $gestion, $folder, $tipo)
	{
		$config['upload_path'] = './uploads/'.$gestion."/".$folder."/".$tipo."/";
		$config['allowed_types'] = '*';
		$config['file_name'] = $nom."-".$tipo;
		return $config;
	}


	#=============================================================================================
	#actualizar documento
	public function updateDoc($idoc)
	{
		$gestion = $this->input->post('gestion');
		$folder = $this->input->post('folder');
		$tipo = $this->input->post('tipo');
		$nom = $this->input->post('nomdoc');
		if($this->upload->do_upload('myremision')){
			$data = $this->upload->data();
			$config = $this->configFile($nom, $gestion, $folder, $tipo);
			$this->load->database();
			$this->db->update("documento", array("nombre_documento"=>$data['file_name']), "iddocumento = ".$iddoc);
		}else{
			print_r($this->upload->display_errors());
		}
	}

	public function update($value='')
	{

		$this->load->database();
		$this->db->update("documento",array("nombre_documento"=>$this->input->post("nombre")), array("iddocumento"=>$this->input->post("iddocumento")));
		echo TRUE;	
	}

	#==============================================================================================
	#Services
	#Obtiene los datos JSON de un documento
	public function get($id)
	{
		$this->load->model("documento_db");
		$docs = $this->documento_db->getDoc($id);
		if($docs->num_rows() > 0)
			echo json_encode($docs->row());
		else
			echo FALSE;
	}

	public function show($id)
	{
		$this->load->database();
		$docs = $this->db->get_where("documento", array("iddocumento"=>$id));
		$doc = $docs->row();
		redirect(base_url($doc->ruta."/".$doc->nombre_documento));
	}

	#=============================================================================================
	#Obtener el documento con sus instancias actuales

	public function get_instancia($iddoc)
	{
		$this->load->model("documento_db");
		$rows = $this->documento_db->ObtenerUltimaInstancia($iddoc);
		
		if($rows->num_rows() == 0){
			echo "En base";
		}else{
			$row = $rows->row();
			echo $row->nombre_instancia;
		}
	}


	#=============================================================================================
	#=============================================================================================
	#Modifica varias instancias de documentos contenidas en un JSON de AngularJS

	public function add_instancias($nom_tipo)
	{
		$objPost = file_get_contents("php://input");
		$post = json_decode($objPost);

		$ins = $post->ins;
		$newins = $post->newins;
		$data = $post->mdata;

		$this->load->model("workflow_db");
		$wf = $this->workflow_db->getBy($nom_tipo, $newins);
		foreach ($data AS $item){
			$this->add_instancia($item->iddoc, $wf->idinstancia_has_workflow);
		}
	}

	#Agrega una nueva instancia a un documento	
	public function add_instancia($iddoc=NULL, $inswf=NULL)
	{
		if(!isset($iddoc) || $iddoc=="" || !isset($inswf) || $inswf ==""){
			$objPost = file_get_contents("php://input");
			$post = json_decode($objPost);
			$iddoc = $post->iddoc;
			$inswf = $post->iddwf;
		}
		$this->load->database();
		$rows = $this->db->get_where("documento_has_workflow",array("documento_iddocumento"=>$iddoc,"idinstancia_has_workflow"=>$inswf));
		if( $rows->num_rows() == 0){
			$this->db->insert("documento_has_workflow",array("documento_iddocumento"=>$iddoc, "idinstancia_has_workflow"=>$inswf, "fecha_reg"=>date("Y-m-d"), "estado_idestado"=>2));
		}
	}

	#=============================================================================================	
	#==============================================================================================
	#registra un documento recientemente agregado

	public function regDoc($nom, $gestion, $tipo, $folder)
	{
		$mydb = $this->load->database('app2',TRUE);
		$tipos = $mydb->get_where('tipo_doc',array("nombre_tipo"=>$tipo));
		$tp = $tipos->row();
		$this->load->model('documento_db');
		$ruta = "/"."uploads/".$gestion."/".$folder."/".$tipo."/";
		$this->load->database();
		return $this->documento_db->insert_doc($nom, $tp->idtipo_doc,$ruta);
	}


	# metodo para crear el directorio donde debe estar el archivo (si existe previo se elimina primero)
	private function crear_directorio($dir){
		#rmdir("./uploads/".$dir);
		if (!file_exists("./uploads/".$dir)) {
			mkdir("./uploads/".$dir, 0777);
		}
  	}

  	private function addMov($base, $usuario, $privilegio, $contenido=''){
		$this->load->helper("config");
		$this->load->model("movimiento_db");
		$id = $this->movimiento_db->mov($base, $usuario, $contenido);
  	}
}

/* End of file Doc.php */
/* Location: ./application/controllers/Doc.php */
