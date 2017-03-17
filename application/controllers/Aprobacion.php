<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aprobacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
		header('Pragma: no-cache'); // HTTP 1.0
		header('Expires: 0'); 
		$this->load->helper("config");
		if(!$this->mysess()){
			redirect(site_url(""));
		}
		
        date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		
	}

	#formulario de aprobación
	public function aprobar($idper, $idcar,$idpercar){	
		if (!isset($idper) || !isset($idcar) || !isset($idpercar)) {
			redirect(site_url());
		}
		$this->load->database();
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('perfil_doc/ver/'.$idper)."'>Ver persona</a>",
				"<a href='".site_url('aprobacion/aprobar/'.$idper."/".$idcar."/".$idpercar)."'>Aprobacion de cargo</a>"
			);
		$pers = $this->db->get_where("persona",array("identificacion"=>$idper));
		$per = $pers->row();
		$cargs = $this->db->get_where("cargo",array("codigo "=>$idcar));
		$carg = $cargs->row();
		$this->myview("aprobaciones/add_aprobacion",$direccion_act,array("per"=>$per, "carg"=>$carg, "idpercar"=>$idpercar));
	}

	#agregar aprobación
	public function add($value=''){
		$tipe = $this->input->post("tipo");
		$id = $this->input->post("idper");
		$usuario = $this->input->post("resu");
		$base = $this->input->post("base");

		$is = TRUE;
		if($tipe == 2){
			$is = FALSE;
		}
		$obser = $this->input->post("obser");
		$idpc = $this->input->post("idpc");
		addlog($this->input->ip_address(), "ingreso de aprobaciona de persona con C.C. ".$id." a cargo, id de relación ".$idpc, 32, $this->session->userdata('idusuario'));		
			$this->load->database("app2");
			$config['upload_path'] = './uploads/persona/'.$id;
			$config['allowed_types'] = '*';
			$config['file_name'] = $id."-aprobacion_cargo";
			$this->load->library("upload",$config);
			if($this->upload->do_upload("file")){
				$data = $this->upload->data();	
				$this->db->insert("aprobacion",array(
						'idpersona_has_cargo'=>$idpc, 
						"observacion"=>$obser, 
						"isaprobacion"=>$is, 
						"documento"=>$data['file_name'],
						"fecha_aprobacion"=> date("Y-m-d") ,
						"usuario_aprueba"=>$usuario,
						"base_aprueba"=>$base
					));
				echo "Proceso realizado";
			}else{
				echo "algo ha fallado :( ". $this->upload->display_errors(); 
			}

	}
	#agregar aprobación2
	public function add2($value=''){
		$tipe = $this->input->post("tipo");
		$id = $this->input->post("idper");
		$obser = $this->input->post("obser");
		$idpc = $this->input->post("idpc");

		$usuario = $this->input->post("resu");
		$base = $this->input->post("base");

		$is = TRUE;
		if($tipe == 2){
			$is = FALSE;
		}
		//addlog($this->input->ip_address(), "ingreso de aprobaciona de persona con C.C. ".$id." a cargo, id de relación ".$idpc, 32, $this->session->userdata('idusuario'));		
		$this->load->database("app2");
		$this->db->insert("aprobacion",array(
				'idpersona_has_cargo'=>$idpc, 
				"observacion"=>$obser, 
				"isaprobacion"=>$is, 
				"documento"=>"#",
				"fecha_aprobacion"=> date("Y-m-d"),
				"usuario_aprueba"=>$usuario,
				"base_aprueba"=>$base
			));
		echo '1';
	}

	private function upload($value=''){

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

	#retorna la observacion
	public function obs($id){
		$this->load->database();
		$aps = $this->db->get_where("aprobacion", array("idaprobacion"=>$id));
		$ap = $aps->row();
		echo $ap->observacion;
	}
	
	#==================================================================
	#funcion que busca los cargos en espera
	public function gestiona_inconclusos($id=NULL, $indicador=0){
		$this->load->database();
		$this->load->model("persona_db");
		$this->load->helper("cargos");
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url("consulta/form_consulta_avanzada")."'>Gestion de consultas avanzadas</a>",
				"<a href='".current_url()."'>Ver inconclusos</a>"
			);
		$pers  = $this->persona_db->enespera($id);
		$this->myview("consultas/ver_todos",$direccion_act, array("personas_cargo"=>$pers,"indicador"=>0,"cant"=>$pers->num_rows, "total"=>$pers->num_rows));
	}
	#Funcion que valida si el perfil gestionado esta aun inconcluso o no
	public function gestiona_incompletos($id=NULL, $indicador=0){
		$this->load->database();
		$this->load->model("persona_db");
		$this->load->helper("cargos");
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url("consulta/form_consulta_avanzada")."'>Gestion de consultas avanzadas</a>",
				"<a href='".current_url()."'>Ver inconclusos</a>"
			);
		$pers  = $this->persona_db->inconclusos();
		$this->myview("consultas/ver_todos",$direccion_act, array("personas_cargo"=>$pers,"indicador"=>0,"cant"=>$pers->num_rows, "total"=>$pers->num_rows));
	}

	#==================================================================
	#Aprobacion masiva
	#==================================================================


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
	#================================================================================
	#Borrar aprobacion
	public function rm($id, $ced)
	{
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url("perfil/form_modificar/".$ced)."'>Editar perfil</a>",
				"<a href='".current_url()."'>Borrar aprobacion</a>"
			);
		$html = "<a class='btn btn-danger' href='".site_url('aprobacion/del/'.$id."/".$ced)."'> Confirmar borrado </a><br><br><a class='btn btn-default' href='".site_url("perfil/ver/".$ced)."'> << Volver</a>";
		$vista = $this->load->view(
					"utilidades_visuales/vista_horizont",
					array(
						"direccion_act"=>$direccion_act, 
						"menu"=>array(array("data-icon='&#xe001'","Volver a vista principal", site_url())), 
						"vista_pr"=>$html					
						), 
					TRUE
				);
		$this->load->view("home",array("vista"=>$vista));
	}
	public function del($id, $ced)
	{
		$this->load->database();
		$aps = $this->db->get_where("aprobacion",array("idaprobacion"=>$id));
		if($aps->num_rows() > 0){
			$row = $aps->row();
			if(unlink("./uploads/persona/".$ced."/".$row->documento)){
				addlog(
						$this->input->ip_address(), 
						"Borrando aprobacion idpersona_has_cargo:".$row->idpersona_has_cargo.", documento ".$row->documento." del perfil con C.C. ".$ced, 
						33, 
						$this->session->userdata('idusuario')
					);
				$this->db->delete("aprobacion",array("idaprobacion"=>$id));
				redirect(site_url('perfil/ver/'.$ced),'refresh');
			}else{
				echo "No se ha borrado: persona/".$ced."/".$row->documento;
			}
		}else{
			echo "Documento no encontrado: persona/".$ced."/".$row->documento;
		}
		
	}

	#=======================================================================
	#private
	public function mysess($value='')
    {
        $sess = $this->session->userdata("isess");
        if(isset($sess) && $sess != NULL && $sess != "")
            return TRUE;
        else
            return FALSE;
    }
}

/* End of file  */
/* Location: ./application/controllers/ */