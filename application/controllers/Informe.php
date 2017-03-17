<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informe extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		$this->form_informes();
	}


	public function get($tipo, $id = NULL)
	{
		$web = $this->input->post("web");
		$this->load->model("informe_db");
		$this->load->helper("cargos");
		if($tipo == "lista"){
			$json = json_decode($this->input->post("json"));
			$rows = $this->informe_db->getByList($json);
			if($web)
				$this->mview("informes/generado/listado_personas",array(),array("personas_cargo"=>$rows, "web"=>FALSE));
			else
				$this->genXLS("informes/generado/listado_personas",array("personas_cargo"=>$rows, "web"=>TRUE), "ConsultaPersonas" );
		}elseif ($tipo == "cargo") {
			$rows = $this->informe_db->getByCargo();
			if($web)
				$this->mview("informes/generado/listado_personas",array(),array("personas_cargo"=>$rows, "web"=>FALSE));
			else
				$this->genXLS("informes/generado/listado_personas",array("personas_cargo"=>$rows, "web"=>TRUE), "ReporteCargos" );
		}elseif ($tipo == "estado") {
			$estado = $this->input->post("estado");
			$status = NULL;
			if($estado == "aprobado")
				$status = TRUE;
			elseif ($estado == "reprobado")
				$status = FALSE;
			$rows = $this->informe_db->getByEstadoAprobacion($status);
			if($web)
				$this->mview("informes/generado/listado_personas",array(),array("personas_cargo"=>$rows, "web"=>FALSE));
			else
				$this->genXLS("informes/generado/listado_personas",array("personas_cargo"=>$rows, "web"=>TRUE), "RepoteEstados" );
		}elseif($tipo == "uploaded"){
			$base = $this->input->post('base');
			if( isset($base) ){
					$rows = $this->informe_db->getByUploaded($base);
					if($web)
						$this->mview("informes/generado/listado_personas",array(),array("personas_cargo"=>$rows, "web"=>FALSE));
					else
						$this->genXLS("informes/generado/listado_personas",array("personas_cargo"=>$rows, "web"=>TRUE), "ReporteCargos" );
			}
		}
	}

	public function genXLS($vista, $arr, $infor = "informe")
	{
		$view = $this->load->view($vista, $arr, TRUE);
		$this->load->view("informes/generado/xls",array("html"=>$view,"informe"=>$infor, "web"=>$web));
	}

	#====================================================================================
	#Obtiene el personal y el cargo (Pueden estar repetidos)
	public function form_informes($value='')
	{
		$direccion_act = array(
					"<a href='".site_url('')."'>App.Termo_gd</a>",
					"<a href='".site_url('consulta/form_consulta_avanzada')."'>Gestion de consultas avanzadas</a>"
				);

		$this->mview("informes/form_getpersonas",array(), $direccion_act);

	}

	public function cargar_form($view, $id = NULL)
	{
		$this->load->view("informes/".$view, array("id"=>$id));
	}

	#=====================================================================================
	#Obtiene el personal aprobado o no aprobado

	#====================================================================================
	#private
	private function mview($vista_pr, $direccion_act, $datos=NULL, $return = FALSE){
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('consulta')."'>consultas</a>",
				"<a href='".current_url()."'>reportes</a>"
			);
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
/* End of file  */
/* Location: ./application/controllers/ */
