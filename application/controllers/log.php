<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library("xmlrpc");
		$this->load->library('xmlrpcs');
		date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
	    $config['functions']['test'] = array('function' => 'Log.addlog');

	    $this->xmlrpcs->initialize($config);
	    $this->xmlrpcs->serve();
	}

	public function addlog($request)
	{
        $parameters = $request->output_parameters();
		$data["direccion_ip"] = $parameters[0];
		$data["actividad_realizada"] = $parameters[1];
		$data["privilegio_idprivilegio"] = $parameters[2];
		$data["usuario_idusuario"] = $parameters[3];
		$data["fecha_actividad"] = date("Y-m-d H:i:s a");
		/*$data["direccion_ip"] = $this->input->post("ip");
		$data["actividad_realizada"] = $this->input->post("actividad");
		$data["privilegio_idprivilegio"] = $this->input->post("privilegio");
		$data["usuario_idusuario"] = $this->input->post("idusuario");*/
		$data["fecha_actividad"] = date("Y-m-d H:i:s a");
		$this->load->database();
		$this->db->insert("log_movimientos",$data);
	    $response = array(array(
                                'respond' => 1
                        ),
                        'struct');
		return $this->xmlrpc->send_response($response);
	}

}

/* End of file  */
/* Location: ./application/controllers/ */