<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informe_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function getByCargo()
	{
		$this->load->database();
		return $this->db->select("p.identificacion, p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido,
									p.base_idbase AS manoobra, p.base_creacion AS basecreacion, c.nombre, pg.idpersona_has_cargo")
						->from("persona As p")
						->join("persona_has_cargo AS pg","pg.persona_identificacion = p.identificacion")
						->join("cargo AS c","pg.cargo_codigo = c.codigo")
						->order_by("p.identificacion","ASC")
						->get();
	}

	public function getByEstadoAprobacion($status)
	{
		$this->load->database();
		return $this->db->select("p.*, g.*, pg.*, p.base_creacion AS basecreacion, p.base_idbase AS manoobra")
					->from("persona As p")
					->join("persona_has_cargo AS pg","pg.persona_identificacion = p.identificacion")
					->join("cargo AS g","pg.cargo_codigo = g.codigo")
					->join("aprobacion AS ap","ap.idpersona_has_cargo = pg.idpersona_has_cargo","LEFT")
					->where("ap.isaprobacion",$status)
					->order_by("p.identificacion","ASC")
					->get();
	}

	public function getByList($list)
	{
		$this->load->database();
		return $this->db->select("p.*, g.*, pg.*, p.base_creacion AS basecreacion, p.base_idbase AS manoobra")
					->from("persona As p")
					->join("persona_has_cargo AS pg","pg.persona_identificacion = p.identificacion")
					->join("cargo AS g","pg.cargo_codigo = g.codigo")
					->where_in("p.identificacion",$list)
					->order_by("p.identificacion","ASC")
					->get();
	}

	public function getByUploaded($base)
	{
		$this->load->database();
		return $this->db->select("p.identificacion, p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido,
									p.base_idbase AS manoobra, p.base_creacion AS basecreacion, c.nombre, pg.idpersona_has_cargo")
						->from("persona As p")
						->join("persona_has_cargo AS pg","pg.persona_identificacion = p.identificacion")
						->join("cargo AS c","pg.cargo_codigo = c.codigo")
						->where("p.base_creacion", $base)
						->order_by("p.identificacion","ASC")
						->get();
	}

}

/* End of file Informe_db.php */
/* Location: ./application/models/Informe_db.php */
