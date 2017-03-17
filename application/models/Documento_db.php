<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documento_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function insert_doc($nombre, $idtipo, $ruta="", $base=NULL, $usuario =NULL){
		try {
			$data = array(
					'nombre_documento' => $nombre, 
					'fecha_subida'=>date("Y-m-d H:i:s"),
					'tipo_doc_idtipo_doc' => $idtipo,
					'ruta'=>$ruta,
					#BORRAR cuando este lo de los movimientos
					'base_creacion'=>$base,
					'usuario_creacion'=>$usuario
				);
			$r = $this->db->insert('documento', $data);
			if(!$r){
				return FALSE;
			}
			return $this->db->insert_id();
		} catch (Exception $e) {
			return FALSE;			
		}
	}

	public function get_total_docs_persona($idper)	{
		try {
			$data = array(
				'persona_identificacion' => $idper, 
				);
			$this->db->from("documento AS d");
			$this->db->join("persona_has_documento AS pd","pd.documento_iddocumento = d.iddocumento");
			$this->db->where("pd.persona_identificacion",$idper);
			$this->db->order_by("fecha_subida","DESC");
			return $this->db->get();
		} catch (Exception $e) {
			return FALSE;
		}
	}
	public function get_doc_persona($idper, $iddoc){
		try {
			$data = array(
				'persona_identificacion' => $idper, 
				);
			$this->db->order_by('fecha_subida', 'desc');
			return $this->db->get_where("documento", $data);
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function modificar_doc_persona($idper,$iddoc,$nombre, $tipo){
		try {
			$where = array(
				'iddocumento'=> $iddoc,
				'persona_identificacion' => $idper
				);
			$data = array('nombre_documento' => $nombre, "tipo" => $tipo);
			$this->db->update("documento", $data, $where);
		} catch (Exception $e) {
			return FALSE;
		}
	}

	#===========================================================================
	public function getDataWf($iddoc)
	{
		$this->load->database();
		$this->db->from("documento AS doc");
		$this->db->join("documento_has_workflow AS docwf", "docwf.documento_iddocumento = doc.iddocumento");
		$this->db->join("estado AS est", "docwf.estado_idestado = est.idestado");
		$this->db->where("docwf.documento_iddocumento",$iddoc);
		return $this->db->get();
	}

	#============================================================================
	#Get my doc
	public function getDoc($id='')
	{
		$this->load->database();
		$this->db->from("documento AS doc");
		$this->db->join("tipo_doc AS tp", "tp.idtipo_doc = doc.tipo_doc_idtipo_doc");
		$this->db->where("doc.iddocumento",$id);
		$this->db->order_by('doc.iddocumento', 'desc');
		return $this->db->get();
	}

	#================================================= 
	#obtener el tipo del documento

	public function getIdTipoDoc($iddoc= NULL)
	{
		$this->load->database();
		$this->db->select("tp.idtipo_doc AS idtipo");
		$this->db->from("documento AS doc");
		$this->db->join("tipo_doc AS tp","doc.tipo_doc_idtipo_doc = tp.idtipo_doc");
		$this->db->where('doc.iddocumento',$iddoc);
		$rows = $this->db->get();
		if($rows->num_rows() < 1){
			return NULL;
		}
		$row = $rows->row();
		return $row->idtipo;
	}

	public function ObtenerUltimaInstancia($iddoc)
	{
		$this->load->database();
		$this->db->select("MAX(docwf.iddocumento_has_workflow) AS idlast, ins.nombre_instancia");
		$this->db->from("documento As doc");
		$this->db->join("documento_has_workflow As docwf", "doc.iddocumento = docwf.documento_iddocumento");
		$this->db->join("instancia_has_workflow As inswf", "inswf.idinstancia_has_workflow = docwf.idinstancia_has_workflow");
		$this->db->join("instancia AS ins", "ins.idinstancia = inswf.instancia_idinstancia");
		$this->db->where("doc.iddocumento",$iddoc);
		$this->db->order_by('docwf.iddocumento_has_workflow', 'desc');
		$this->db->group_by("docwf.iddocumento_has_workflow");
		$rows = $this->db->get();
		$this->db->close();
		return $rows;
	}

}

/* End of file  */
/* Location: ./application/models/ */