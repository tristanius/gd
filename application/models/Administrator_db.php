<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function add_privilegio($obj)
	{
		$data = array(
				'Nombre_privilegio' => $obj->nombre_privilegio,
				'ruta' => $obj->ruta,
				'activo' => TRUE,
				'gestion_idgestion' => $obj->gestion_idgestion
			);
		$this->load->database();
		$this->db->insert("privilegio", $data);
		return $this->db->insert_id();
	}

	public function add_rol($obj)
	{
		$data = array(
				'nombre_rol'=>$obj->nombre_rol,
				'activo'=>TRUE
			);
		$this->load->database();
		$this->db->insert('rol', $data);
		return $this->db->insert_id();
	}

	public function add_privilegio_rol($obj)
	{
		$data = array(
				'privilegio_idprivilegio '=> $obj->privilegio_idprivilegio ,
				'rol_idrol'=> $obj->rol_idrol
			);
		$this->load->database();
		$this->db->insert('privilegio_has_rol', $data);
		return $this->db->insert_id();
	}

	public function add_usuario($obj)
	{
		$data = array(
				'username' => $obj->persona_identificacion,
				'persona_identificacion' => $obj->persona_identificacion,
				'nombres' => $obj->nombres, 
				'apellidos' => $obj->apellidos,
				'correo' => $obj->correo,
				'base_idbase' => $obj->base_idbase,
				'rol_idrol' => $obj->rol_idrol,
				'password' => $obj->password
			);
		$this->load->database();
		$this->db->insert('usuario', $data);
		return $this->db->insert_id();
	}

	#============================================================================================
	# consultas

	#privilegios de un rol
	public function getRolPrivilegios($idrol)
	{
		$this->load->database();
		$rows = $this->db->from("privilegio_has_rol AS prrol")
			->join("rol", "rol.idrol = prrol.rol_idrol")
			->join("privilegio As pr", "pr.idprivilegio = prrol.privilegio_idprivilegio")
			->where("rol.idrol",$idrol)
			->order_by("pr.idprivilegio","ASC")
			->get();
		return $rows;
	}
}

/* End of file Administrator.php */
/* Location: ./application/models/Administrator.php */