<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		
	}

	public function checkmemo(){
		$this->load->database("app1");
		$this->db->from("memo");
		$this->db->where("usuario_idusuario", $this->session->userdata('idusuario'));
		$this->db->where('isvisto', FALSE );
		$rows = $this->db->get();
		echo $rows->num_rows();
	}

	public function getmemos($new = NULL){
		$this->load->database("app1");
		$this->db->from("memo");
		$this->db->where("usuario_idusuario", $this->session->userdata('idusuario'));
		if (isset($new)) {
			$this->db->where('isvisto', FALSE );
		}
		$direccion_act = array(
				"<a href='".site_url()."'>App.termo_gd</a>",
				"<a href='".site_url("notificacion/getmemos/")."'> Gestion de mensajes </a>",
				"<a href='".current_url()."'> Memos </a>"
			);
		$this->db->order_by('idmemo', 'desc');
		$rows = $this->db->get();
		$this->db->update("memo", array('isvisto'=> TRUE), array('usuario_idusuario'=>$this->session->userdata('idusuario'), 'isvisto'=>FALSE) );
		$this->myview("notificacion/mensaje",$direccion_act,array('mensajes'=>$rows));

	}

	public function isvisto()
	{
		
	}
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

/* End of file notificaciones.php */
/* Location: ./application/controllers/notificaciones.php */