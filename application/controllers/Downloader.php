<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downloader extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		
	}

	public function test($value='')
	{
		$this->load->library("zip");
		$paths = array(
			'./uploads/test/Boletin 1-TC.pdf',
			'./uploads/test/DLinkNAS_asdasd.pdf',
			"./uploads/test2/VirtualBox - UserManual.pdf",
			"./uploads/test2/Redes informaticas Nociones fundamentales, 4ta Edicion.www.DD-BOOKS.com.pdf");
		$i = 0;
		foreach ($paths as $item) {
			$i++;
			$this->zip->read_file($item,"./MA-0032887 ".$i.".pdf");
		}
		$this->zip->download('OT. YEISON');
	}

	public function migrar1($value='')
	{
		$this->load->database();
		$this->load->model("migracion");
		$this->migracion->actualizarCargos();
		$this->migracion->nuevosCargos(160);
	}

}

/* End of file Downloader.php */
/* Location: ./application/controllers/Downloader.php */