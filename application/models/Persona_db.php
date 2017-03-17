<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persona_db extends CI_Model {

	public $variable;

	public function __construct(){
		parent::__construct();
	}
	public function get($id)
	{
		$this->load->database();
		return $this->db->get_where('persona',array("identificacion"=>$id));
	}

	public function get_persona($id=NULL, $nom1 = NULL, $nom2 = NULL,
						$ape1 = NULL, $ape2 = NULL, $join_cargo = FALSE){
		$this->db->from("persona");
		if($join_cargo){

		}
		if (isset($id)) {
			$this->db->where('identificacion', $id);
		}
		if (isset($nom1)) {
			$this->db->where("primer_nombre",$nom1);
		}
		if (isset($nom2)) {
			$this->db->where("segundo_nombre",$nom2);
		}
		if (isset($ape1)){
			$this->db->where("primer_apellido",$ape1);
		}
		if (isset($ape2)) {
			$this->db->where("segundo_apellido",$ape2);
		}
		$this->db->order_by("identificacion","DESC");
		return $this->db->get();
	}

	public function insertar_persona($id, $nom1, $nom2, $ape1, $ape2 ){
		try {
			$data = array(
				"identificacion"=>$id,
				"primer_nombre"=>$nom1,
				"segundo_nombre"=>$nom2,
				"primer_apellido"=>$ape1,
				"segundo_apellido"=>$ape2
			);
			return $this->db->insert('persona',$data);
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function insert_persona_x_cargo($idper, $idcarg, $base=NULL, $usuario=NULL){
		try {
			$data = array(
					"persona_identificacion"=>$idper,
					"cargo_codigo"=>$idcarg,
					"fecha_cargo"=>date("Y-m-d"),
					"base_creacion"=>$base,
					"usuario_creacion"=>$usuario
				);
			$this->db->insert('persona_has_cargo', $data);
		} catch (Exception $e) {
			return FALSE;
		}
	}


	#=========================================================================
	#consultas

	public function existe_persona($idper=''){
		try {
			$pers = $this->db->get_where("persona",array("identificacion"=>$idper));
			if($pers->num_rows() <= 0)
				return FALSE;
			else
				return TRUE;
		} catch (Exception $e) {
			return "error: ".$e->getMessage();
		}
	}
	public function get_persona_id($idper){
		try {
			$pers =  $this->db->get_where("persona",array("identificacion"=>$idper));
			return $pers;
		} catch (Exception $e) {
			return FALSE;
		}
	}

	#consulta 'dinamica'

	public function consultar_persona_cargo(
										$idper = NULL,
										$cargos = NULL,
										$ncargos = 0,
										$init=NULL,
										$limit=NULL,
										$nom = NULL)
	{
		$this->db->select("*, p.base_creacion As basecreacion");
		$this->db->from("persona AS p");
		$this->db->join("persona_has_cargo AS pc", "p.identificacion = pc.persona_identificacion","LEFT");
		$this->db->join("cargo AS c", "c.codigo = pc.cargo_codigo","LEFT");
		if (isset($idper) && $idper != '') {
			$this->db->where('p.identificacion', $idper);
		}
		if(isset($cargos)){
			foreach ($cargos as $key => $value) {
				$this->db->or_where("c.codigo", $value);
			}
		}
		#$this->db->group_by("p.identificacion");
		if (isset($init) && isset($limit)) {
			$this->db->limit($limit, $init);
		}else{
			$this->db->order_by('p.identificacion', 'desc');
			$this->db->order_by('c.codigo', 'Asc');
		}
		if(isset($nom) && $nom != ''){
			$this->db->like('p.primer_nombre', $nom);
			$this->db->or_like('p.segundo_nombre', $nom);
			$this->db->or_like('p.primer_apellido', $nom);
			$this->db->or_like('p.segundo_apellido', $nom);

		}
		return $this->db->get();
	}

	#get cursos por persona
	public function get_cursos_persona($idper)
	{
		return $this->db->get_where("curso", array("persona_identificacion"=>$idper));
	}
	#===================================================================================
	# Modificar datos.
	public function modificar_datos($idper, $nom1, $nom2, $ape1, $ape2, $esco, $titulo, $mobra, $base=NULL, $user=NULL)
	{
		try {
			if($mobra)
				$mobra = TRUE;
			$data = array(
				'primer_nombre' =>  $nom1,
				'segundo_nombre' => $nom2,
				'primer_apellido' =>$ape1,
				'segundo_apellido' => $ape2,
				'mobra_local' => $mobra,
				'base_idbase' => $base,
				'titulo' => $titulo,
				'escolaridad' =>$esco,
				#BORRAR cuando este lo de los movimientos
				'base_creacion' =>$base,
				'usuario_creacion'=>$user
			);
			$this->db->update('persona', $data, 'identificacion = "'.$idper.'"');
			return TRUE;
		} catch (Exception $e) {
			return FALSE;
		}
	}

	#===================================================================================
	# perfiles en espera
	public function enespera($id){
		$this->db->select("*, p.base_creacion AS basecreacion")
				->from("persona AS p")
				->join("persona_has_cargo AS pc","p.identificacion = pc.persona_identificacion","LEFT")
				->join("cargo AS c"," pc.cargo_codigo = c.codigo","LEFT")
				->where("pc.idpersona_has_cargo NOT IN (SELECT idpersona_has_cargo FROM aprobacion)");
		if(isset($id))
			$this->db->where("p.identificacion",$id);
		return $this->db->get();
	}

	#===================================================================================
	# perfiles inconclusos
	public function inconclusos($id=NULL){
		$this->db->select("*, p.base_creacion AS basecreacion")
				->from("persona AS p")
				->join("persona_has_cargo AS pc","p.identificacion = pc.persona_identificacion","LEFT")
				->join("cargo AS c"," pc.cargo_codigo = c.codigo","LEFT")
				->where("p.identificacion NOT IN (SELECT persona_identificacion FROM persona_has_cargo)")
				->or_where("primer_apellido","")
				->or_where("primer_nombre","");
		return $this->db->get();
	}


	#=======================================================================================
	#agregar un curso
	public function addCurso($idper, $nom, $fecha, $vigencia)
	{
		try {
			$this->db->insert('curso', array("persona_identificacion"=>$idper, "nom_curso"=>$nom, "fecha_exp"=>$fecha, "vigencia"=>$vigencia));
			return TRUE;	
		} catch (Exception $e) {
			return FALSE;
		}		
	}


	#===================================================================================
	#

	private function gen_data($id = NULL, $nom1 = NULL, $nom2 = NULL, $ape1 = NULL, $ape2=NULL){

	}

}

/* End of file  */
/* Location: ./application/models/ */
