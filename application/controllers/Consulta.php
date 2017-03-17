<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consulta extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
		header('Pragma: no-cache'); // HTTP 1.0
		header('Expires: 0'); 
		$this->load->helper("config");
		$this->load->helper("cargos");
		if(!$this->mysess())
			redirect(app_termo());
        date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		$this->form_consulta_avanzada();
	}

	public function form_consulta_avanzada()
	{
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".current_url()."'>Gestion de consultas avanzadas</a>"
			);
		$menu = $this->menu(FALSE, TRUE);
		$this->crear_view("consultas/form_consulta_avanzada", $menu,$direccion_act);
	}

	public function form_consulta_cargos($item)
	{
		$this->load->database();
		$cargos = $this->db->get("cargo");
		echo $this->load->view("consultas/form_consulta_cargo",
				array("item"=>$item, "cargos"=>$cargos),
				TRUE);
	}
	public function form_consulta_ced()
	{
		echo $this->load->view("consultas/form_consulta_cedula",array(),TRUE);
	}
	public function form_consulta_nombre()
	{
		echo $this->load->view("consultas/form_consulta_nombre",array(),TRUE);
	}


	#==============================================================
	#consulta 
	public function get_consulta()
	{
		$ncargos = $this->input->post("ncargos");
		$cargos = array();
		$ced = $this->input->post("cedula");
		$nom = $this->input->post("nombre");
		/*while ($post = each($_POST)){
			echo $post[0] . " = " . $post[1]."; ";
		}*/
		if (isset($ncargos) && $ncargos >= 0) {
			for ($i=1; $i <=$ncargos ; $i++) { 
				array_push($cargos, $this->input->post("cargo".$i));
			}
			$direccion_act = array(
					"<a href='".site_url('')."'>App.Termo_gd</a>",
					"<a href='".site_url('consulta/form_consulta_avanzada')."'>Gestion de consultas avanzadas</a>"
				);
			$menu = $this->menu(FALSE, TRUE);
			$this->load->database();
			$this->load->model("persona_db");
			$resul = $this->persona_db->consultar_persona_cargo($ced, $cargos, $ncargos, NULL, NULL, $nom);
			echo $this->crear_view("consultas/resultado_personas", $menu,$direccion_act,array("personas_cargo"=>$resul));
		}else{
			redirect(site_url("consulta/form_consulta_avanzada"));
		}
	}

	#ver todos
	public function vertodos($indicador=0){
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url("consulta/form_consulta_avanzada")."'>Gestion de consultas avanzadas</a>",
				"<a href='".site_url("consulta/vertodos/0")."'>Ver todos</a>"
			);
		$menu = $this->menu(FALSE, TRUE);
		$this->load->database();
		$resul = $this->get_persona_by($indicador, 100);
		$total = $this->db->query('SELECT COUNT(identificacion) AS no FROM persona')->row();
		$cant = $resul->num_rows();
		echo $this->crear_view(
				"consultas/ver_todos", 
				$menu,$direccion_act,
				array("personas_cargo"=>$resul,"cant"=>$cant, "total"=>$total->no, "indicador"=>$indicador)
			);
	}

	public function get_persona_by($init=0, $cantidad=100, $indicador=NULL)
	{
		$this->load->model("persona_db");
		#Modificacion
		$cant = NULL;
		$cantidad = NULL;
		$resul = $this->persona_db->consultar_persona_cargo(NULL, NULL, NULL, $init, $cantidad);
		return $resul;
	}
	#================================================================================================
	#consulta los perfiles inconclusos
	public function gestiona_inconclusos($id=NULL, $indicador=0){
		$this->load->database();
		$this->load->model("persona_db");
		$menu = array(
					array("data-icon='&#xe001'","Volver a vista principal", site_url())
				);
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url("consulta/form_consulta_avanzada")."'>Gestion de consultas avanzadas</a>",
				"<a href='".current_url()."'>Ver inconclusos</a>"
			);
		$pers  = $this->persona_db->inconclusos($id);
		$this->crear_view("consultas/ver_todos",$menu,$direccion_act, array("personas_cargo"=>$pers,"indicador"=>0,"cant"=>$pers->num_rows, "total"=>$pers->num_rows));
	}

	#===================================================================================================
	#
	public function imprimir($param=NULL)
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$query = $this->db->query("SELECT * FROM persona");
		echo write_file('./uploads/csv_file.csv', $this->dbutil->csv_from_result($query));
	}

	#============================================================
	#private

	private function crear_view($vista_pr, $menu, $direccion_act, $datos=NULL, $return = FALSE){
		$vista_pr = $this->load->view($vista_pr, $datos,TRUE);
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


	private function menu($prin = TRUE, $back = FALSE){
		$menu = array();
		if($prin){
			$menu = array(
					array("data-icon='%'","Agregar nueva hoja de vida y cargos",site_url("perfil_doc/form_add_perfil")),
					array("data-icon='8'","Gestión de hojas de vida y cargos.", site_url("perfil_doc/form_gestion_perfiles")),
					array("data-icon='D'","Consultas consultas de perfiles", site_url("perfil_doc/form_consulta_avanzada"))
				);
		}
		else if($back){
			$menu = array(
					array("data-icon='&#xe001'","Volver a vista principal", site_url())
				);
		}
		return $menu;
	}

	public function mysess($value='')
    {
        $sess = $this->session->userdata("isess");
        if(isset($sess) && $sess != NULL && $sess != "")
            return TRUE;
        else
            return FALSE;
    }
}

/* End of file consultas.php */
/* Location: ./application/controllers/consultas.php */