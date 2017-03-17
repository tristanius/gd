<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	#=================================================================================
	# privilegios
	#=================================================================================
	public function privilegios($value='')
	{
		$direccion_act = array(
				'<a href="'.site_url('').'">App termo</a>',
				'<a href="#"">Admin</a>',
				'<a href="'.current_url('').'">Privilegios</a>'
			);
		$this->load->database();
		$rows = $this->db->get("privilegio");
		$gestiones = $this->db->get("gestion");

		$this->crear_vista("Administrator/privilegios",array("privilegios"=>$rows, "gestiones"=>$gestiones), $direccion_act);
	}

	public function add_privilegio()
	{
		$objPost = file_get_contents("php://input");
		$post = json_decode($objPost);
		
		$this->load->model("administrator_db");
		$this->administrator_db->add_privilegio($post);
		echo json_encode($post);
	}


	#=================================================================================
	# roles
	#=================================================================================
	public function roles($value='')
	{
		$direccion_act = array(
				'<a href="'.site_url('').'">App termo</a>',
				'<a href="#">Admin</a>',
				'<a href="'.current_url('').'">Roles</a>'
			);
		$this->load->database();
		$rows = $this->db->get("rol");
		
		$this->crear_vista("Administrator/roles",array("roles"=>$rows),$direccion_act);
	}

	public function add_rol($value='')
	{
		$objPost = file_get_contents("php://input");
		$post = json_decode($objPost);

		$this->load->model("administrator_db");
		$id = $this->administrator_db->add_rol($post);
		$post->idrol = $id;
		echo json_encode($post);
	}

	#=================================================================================
	# roles has privilegios
	#=================================================================================
	public function rol_privilegios($idrol)
	{
		$direccion_act = array(
				'<a href="'.site_url('').'">App termo</a>',
				'<a href="#">Admin</a>',
				'<a href="'.current_url('').'">privilegios del rol</a>'
			);

		$this->load->database();
		$rol = $this->db->get_where("rol",array("idrol"=>$idrol))->row();
		$privilegios = $this->db->get_where("privilegio", "nombre_privilegio != ''");
		$this->db->close();

		$this->load->model("administrator_db");
		$rows = $this->administrator_db->getRolPrivilegios($idrol);
		$this->crear_vista("Administrator/rol_privilegios",array("rol"=>$rol, "privilegios_rol"=>$rows, "privilegios"=>$privilegios),$direccion_act);
	}

	public function add_privilegio_rol($value='')
	{
		$objPost = file_get_contents("php://input");
		$post = json_decode($objPost);

		$this->load->model("administrator_db");
		$id = $this->administrator_db->add_privilegio_rol($post);
		$post->idprivilegio_has_rol = $id;
		echo json_encode($post);
	}
	#=================================================================================
	# usuarios
	#=================================================================================
	public function usuarios($value='')
	{
		$direccion_act = array(
				'<a href="'.site_url('').'">App termo</a>',
				'<a href="#">Admin</a>',
				'<a href="'.current_url('').'">Usuarios</a>'
			);
		$this->load->database();
		$rows = $this->db->from("usuario AS usr")->join("rol", "usr.rol_idrol = rol.idrol")->get();
		$roles = $this->db->get("rol");
		
		$this->crear_vista("Administrator/usuarios",array("usuarios"=>$rows, "roles"=>$roles),$direccion_act);
	}

	public function add_usuario($value='')
	{
		$objPost = file_get_contents("php://input");
		$post = json_decode($objPost);

		$this->load->library("encrypt");
		$pass = $this->encrypt->encode($post->persona_identificacion);

		$this->load->model("administrator_db");
		$post->password = $pass;

		$post->idusuario = $this->administrator_db->add_usuario($post);
		echo json_encode($post);
	}

	#=================================================================================
	# privados utiles
	#=================================================================================
	public function crear_vista($vista, $data, $direccion_act){

		$html = $this->load->view($vista, $data, TRUE);
		
		$vista = $this->load->view("utilidades_visuales/vista_panel",
				array(
					"vista_pr"=>$html,
					"direccion_act"=>$direccion_act
					),
				TRUE );
		$this->load->view("home",array("vista"=>$vista));
	}

}

/* End of file Administrator.php */
/* Location: ./application/controllers/Administrator.php */