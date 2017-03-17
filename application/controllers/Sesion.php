<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("config");
		date_default_timezone_set("America/Bogota");
	}

	public function index(){
		$this->ini();
	}

	public function ini(){
		try {
			$this->load->library("encrypt");
			$id = $this->input->post("d1");
			$user = $this->input->post("d4");
			$per = $this->input->post("d5");
			$base = $this->input->post("d6");
			$data = $this->input->post("d3");
			$nombre_usuario = $this->input->post("d7");
			if(!isset($id) && !isset($data)){
				echo "fallo de entrega de datos";
				return;
			}
			#$nid = $this->encrypt->decode($id);
			$sess= json_decode($data);
			$this->load->library("session");
			$this->session->set_userdata(array(
					"apps"=>$sess[2]->apps, 
					"gestiones"=>$sess[1]->gestiones, 
					"privilegios"=>$sess[0]->privilegios, 
					"idpersona" =>$per,
					"idusuario" =>$user,
					"usuario" =>$id,
					"base_idbase"=>$base,
					"isess"=>TRUE,
					"nombre_usuario"=>$nombre_usuario)
				);
			echo $this->buscar_app($sess[2]->apps);
		} catch (Exception $e) {
			echo $e->getMessege();
		}
	}
	public function ini2(){
		$this->load->library("session");
		$this->session->set_userdata("usuario","testing yeison");
	}
	public function data(){
		$this->load->library("session");
		print_r($this->session->all_userdata('item'));
	}

	public function buscar_app($data){
		foreach ($data as $key => $value) {
			return true;
		}
		return "no encontrada";
	}

	public function get_user($id="")
	{
		echo "";
		$this->load->database("app1");
		$rows = $this->db->get_where("usuario",array("idusuario"=>$id));
		if($rows->num_rows() <= 0){
			echo "Registro invalido o no encontrado";
		}else{
			$r = $rows->row();
			echo $r->nombres." ".$r->apellidos;
		}
	}

	#=====================================
	public function finalizar($redir=NULL){
		$this->session->sess_destroy();
		echo TRUE;
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
