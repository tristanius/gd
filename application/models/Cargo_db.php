<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cargo_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function insert_cargo($id, $nom, $item){
		try {
			$data = array(
				'codigo' => $id,
				'nombre' => $nom,
				'item' =>$item
				);
			return $this->db->insert('cargo', $data);
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function delete_cargo_item($item){
		try {
			/*
			Este se debe refinar para evitar registros historicos necesarios,
			se recomienda mejorar con validaciones y consultas para blidarse de errores.
			*/
			$this->db->delete("cargo", array("item"=>$item));
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function insert_persona_x_cargo($idper, $idcarg, $base=NULL, $usuario=NULL){
		try {
			$data = array(
					"persona_identificacion"=>$idper,
					"cargo_codigo"=>$idcarg,
					"base_creacion"=>$base, 
					"usuario_creacion"=>$usuario
				);
			return $this->db->insert('persona_has_cargo', $data);
		} catch (Exception $e) {
			return FALSE;
		}
	}

	#============================= consultas ==========================
	public function get_cargos_per($idper){
		try {
			$this->db->from("cargo AS c");
			$this->db->join("persona_has_cargo AS pg", "pg.cargo_codigo = c.codigo");
			$this->db->where('pg.persona_identificacion', $idper);
			return $this->db->get();
		} catch (Exception $e) {
			return $e->getMessege();
		}
	}

}

/* End of file  */
/* Location: ./application/models/ */