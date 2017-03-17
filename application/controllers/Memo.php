<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Memo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper("config");
	}

	public function index()
	{
		$vista = $this->load->view("memo/ini","",TRUE);
		$mymenu = $this->load->view("memo/menu","",TRUE);
		$direccion_act = array(
				"<a href='".site_url()."'>App.termo_gd</a>",
				"<a href='".site_url('memo/')."'>Gestión de documentos de recepción</a>"
			);
		$this->myview("memo/panel",$direccion_act, array('vista' => $vista, 'mymenu'=>$mymenu));
	}
	#---------------------------------------
	public function adder(){
		$mymenu = NULL;
		$vista = $this->load->view("memo/form_add","",TRUE);
		$direccion_act = array(
				"<a href='".site_url()."'>App.termo_gd</a>",
				"<a href='".site_url('memo/')."'>Gestión de documentos de recepción</a>",
				"<a href='".site_url('memo/adder')."'>Agregar documentos de recepción</a>"
			);
		$this->myview("memo/panel",$direccion_act, array('vista' => $vista, 'mymenu'=>$mymenu));
	}

	#---------------------------------------
	public function upload($value='')
	{
		$termo = "890903035-2";
		$type = $this->input->post("tipo");
		$no = $this->input->post("no");
		$type2 = $type."_".$no;
		$this->crear_directorio($termo);
		$config['upload_path'] = './uploads/'.$termo;
		$config['allowed_types'] = '*';
		$config['file_name'] = $termo."-".$type2;
		$this->load->library("upload",$config);
		if($this->upload->do_upload("file")){
			$data = $this->upload->data();
			$regis = $this->registrar_doc($termo, $data['file_name'],$type);
			echo "Archivo ".$data['file_name']." - Exito! la insercion esta completada ";
		}else{
			echo "algo ha fallado :( ". $this->upload->display_errors(); 
		}
	}

	# metodo para crear el directorio donde debe estar el archivo (si existe previo se elimina primero)
	private function crear_directorio($dir){
		#rmdir("./uploads/".$dir);
		if(!file_exists("./uploads/".$dir))
		    mkdir("./uploads/".$dir, 0777);
    }
    	# metodo para eliminar el arbol de subdirectorios y archivos
    	private function eliminar_arbol($carpeta){
			foreach(glob($carpeta . "/*") as $archivos_carpeta){
				#echo $archivos_carpeta;
				if (is_dir($archivos_carpeta)){
					eliminarDir($archivos_carpeta);
				}else{
					unlink($archivos_carpeta);
				}
			}		 
			rmdir($carpeta);
		}

	# Aqui registramos en la base de datos el archivo que se subio y a quien pertenece
	private function registrar_doc($idper, $nombre, $tipo = "hoja de vida"){
		try {
			$this->load->database();
			$this->load->model("documento_db");
			return $this->documento_db->insert_doc($idper, $nombre, $tipo);
		} catch (Exception $e) {
			return false;
		}
	}
	#====================================================================================================================
	#borrar
	public function del($id='')
	{
		$this->load->database();
		$docs = $this->db->get_where("documento","iddocumento = ".$id);
		$dc = $docs->row();
		$memos = $this->db->get_where("memo","idmemo = ".$dc->iddocumento);
		$memo = $memos->row();		
		unlink("./uploads/".$this->session->userdata("idpersona")."/".$dc->nombre_documento);
		if($memos->num_rows() > 0)
			$this->db->delete("memo", "idmemo = ".$memo->idmemo);
		if($docs->num_rows() > 0)
			$this->db->delete("documento", "iddocumento = ".$dc->iddocumento);
		redirect(site_url('memo/list_by'));
	}

	#====================================================================================================================
	#
	public function list_by($value='')
	{
		$this->load->database();
		$this->db->order_by('fecha_subida', 'desc');
		$this->db->limit(300);
		$termo = "890903035-2";
		$docs = $this->db->get_where("documento","persona_identificacion = '".$termo."'");
		$mymenu = NULL;
		$vista = $this->load->view("memo/admin_docs",array("docs"=>$docs),TRUE);
		$direccion_act = array(
				"<a href='".site_url()."'>App.termo_gd</a>",
				"<a href='".site_url('memo/')."'>Gestión de documentos de recepción</a>",
				"<a href='".site_url('memo/list_by')."'>Lista de documentos de recepción</a>"
			);
		$this->myview("memo/panel",$direccion_act, array('vista' => $vista, 'mymenu'=>$mymenu));
	}
	#=================================================================================================================
	#ENVIA A UN USUARIO
	public function envia($iddocumento)
	{
		$bd2 = $this->load->database("app2",TRUE);
		$docs = $bd2->get_where("documento",array("iddocumento"=>$iddocumento));
		$mymenu = NULL;
		$doc = $docs->row();

		#require_once APPPATH."/libraries/Requests.php";
		#Requests::register_autoloader();
		#$request = Requests::post(app_termo()."/index.php/usuario/service_get_users", array(), array());
		$vista = $this->load->view("memo/form_enviar",array("doc"=>$doc),TRUE);
		$direccion_act = array(
				"<a href='".site_url()."'>App.termo_gd</a>",
				"<a href='".site_url('memo/')."'>Gestión de documentos de recepción</a>",
				"<a href='".site_url('memo/list_by')."'>Lista de documentos de recepción</a>"
			);
		$this->myview("memo/panel",$direccion_act, array('vista' => $vista, 'mymenu'=>$mymenu));
	}

	public function enviar(){
		$nom = $this->input->post("nom");
		$doc = $this->input->post("doc");
		$iduser = $this->input->post("user");
		$ruta = app_termo("app.termo_gd")."/".$doc;
		$this->load->database("app1");
		addlog($this->input->ip_address(), "Envio de memo ".$nom." al usuario ".$user, 39, $this->session->userdata('idusuario'));
		$this->db->insert("memo", array("ruta"=>$doc, "nombre_memo"=>$nom, "usuario_idusuario"=>$iduser, "fecha_envio"=>date("Y-m-d H:i:s")));
		redirect(site_url("memo/list_by"));
	}

	#==================================================================
	#gestor de vista
	#============================================================
	#private
	private function myview($vista_pr, $direccion_act, $datos=NULL, $return = FALSE){
		$vista_pr = $this->load->view($vista_pr, $datos,TRUE);
		$menu = array(
					array("data-icon='&#xe001'","Volver a vista principal", site_url())
				);
		$vista = $this->load->view(
				"utilidades_visuales/vista_horizont",
				array(
					"direccion_act"=>$direccion_act, 
					"menu"=>$menu, 
					"vista_pr"=>$vista_pr					
					), 
				TRUE
				);
		if($return)
			$home = $this->load->view("home",array("vista"=>$vista),TRUE);
		else 
			$this->load->view("home",array("vista"=>$vista));
	}


}

/* End of file memo.php */
/* Location: ./application/controllers/memo.php */