<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
		header('Pragma: no-cache'); // HTTP 1.0
		header('Expires: 0'); 
		$this->load->library("session");
		$this->load->helper('config');
		date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		if(!$this->sesion_iniciada()){
			redirect(site_url(""));
		}
		$direccion_act = array(
			'Panel de usuario',
			'inicio' );
		$this->crear_vista("panel_inicio/panel_ini",array(), $direccion_act, 0);
		$this->sesion_iniciada();
	}


	public function gestiones($err=NULL){
		if(!$this->sesion_iniciada()){
			redirect(site_url(""));
		}
		$direccion_act = array(
			'Panel de usuario',
			'inicio' );
		$this->crear_vista("panel_inicio/panel_gestiones",array("err"=>$err), $direccion_act, 1);
	}

	public function config_session(){
		if(!$this->sesion_iniciada()){
			redirect(site_url(""));
		}
		$direccion_act = array(
			'Panel de usuario',
			'inicio' );
		$this->crear_vista("panel_inicio/panel_gestiones",array(), $direccion_act, 1);
	}
	public function sesion(){
		if(!$this->sesion_iniciada()){
			redirect(site_url(""));
		}
		$direccion_act = array(
			'Panel de usuario',
			'inicio' );
		$this->crear_vista("panel_inicio/panel_session",array(), $direccion_act, 3);
	}

	#================================================================
	#privados
	#================================================================

	#cargar menu lateral
	public function cargar_menu_lat()
	{
		$menu = array(
				#array("icono","texto","url"),
				array('data-icon="C"','panel incio', site_url("panel")),
				//array('data-icon="t"','Gestiones', site_url("panel/gestiones")),
				array('data-icon="z"','Configuración de cuenta', site_url("sesion/config")),
				array('data-icon="@"','Sesión', site_url('panel/sesion'))
			);
		return $menu; 
	}
	#comprobar sesion; Si la session ha sido iniciada retorna TRUE en otro caso Retorna FALSE.

	private function sesion_iniciada()
	{
		$this->load->library("session");
		if($this->session->userdata("isess")){
			return TRUE;
		}
		return FALSE;
	}

	public function crear_vista($vista, $data, $direccion_act, $selected ,$ismenu = TRUE ){
		if(isset($ismenu)){
			$menu = $this->cargar_menu_lat();
		}			
		$html = $this->load->view($vista, $data, TRUE);
		$vista = $this->load->view("utilidades_visuales/vista_panel",
				array(
					"vista_pr"=>$html, 
					"menu"=>$menu,
					"selected"=>$selected,
					"direccion_act"=>$direccion_act
					),
				TRUE );
		$this->load->view("home",array("vista"=>$vista));
	}

}

/* End of file  */
/* Location: ./application/controllers/ */