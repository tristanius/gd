<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		
	}

	public function service_get_users($value='')
	{
		$this->load->database();
		$users = $this->db->get("usuario");
		$data = "";
		foreach ($users->result() as $us) {
			$data = $data."
			<option value='".$us->idusuario."'>".$us->persona_identificacion." - ".$us->nombres." ".$us->apellidos."</option>";
		}
		echo $data;
	}

}

/* End of file  */
/* Location: ./application/controllers/ */