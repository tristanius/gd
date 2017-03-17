<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("config");
	}

	public function index()
	{
		$this->load->library("session");
		print_r($this->session->all_userdata());
	}
	public function init()
	{
		$this->load->library("session");
		$id = $this->input->post("id");
		$pass = $this->input->post("pass");
		$this->session->set_userdata(array("id"=>$id, "pass"=>$pass));
		print_r($this->session->all_userdata() );
	}

	public function valid(){
		$this->load->library("session");
		if($this->session->userdata("id") === "1090422853"){
			echo "activa... se desactivara";
			$this->session->sess_destroy();
		}
		else{
			echo "no activa :(";
		}
	}

	public function sendxml($actividad="TEST", $privilegio=1)
	{
		$this->load->library("xmlrpc");
		$this->load->helper("config");
		$server = "http://localhost/app.termo/index.php/log";
		$this->xmlrpc->server($server);
        $this->xmlrpc->method('test');

        $request = array(
	        		''.$this->input->ip_address(),
	        		"test",
	        		2,
	        		$this->session->userdata("idusuario")
        		);
        $this->xmlrpc->request($request);

        if ( ! $this->xmlrpc->send_request())
              return FALSE;
        else
        	return TRUE;
	}

}

/* End of file  */
/* Location: ./application/controllers/ */