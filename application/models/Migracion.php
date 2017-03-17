<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migracion extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	#migracion 1
	public function actualizarCargos($value='')
	{
		$cargos2 = $this->db->get("cargo2") ;
		foreach ($cargos2->result() as $c2) {
			$this->db->update("cargo", array("nombre"=>$c2->nombre), "codigo = ".$c2->codigo);
		}
	}
	public function nuevosCargos($inicio)
	{
		$cargos2 = $this->db->get_where("cargo2",array("codigo >= "=>$inicio)) ;
		foreach ($cargos2->result() as $c2) {
			$this->db->insert("cargo", array("codigo"=>$c2->codigo,"nombre"=>$c2->nombre));
		}
	}

}

/* End of file Migracion.php */
/* Location: ./application/models/Migracion.php */