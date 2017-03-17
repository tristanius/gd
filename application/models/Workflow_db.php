<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workflow_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}
	public function get($idwf=NULL, $idtp=NULL, $iddoc=NULL)
	{
		$this->load->database();
		$this->db->select("wf.idworkflow AS id, wfins.idinstancia_has_workflow AS idinstanciawf, wf.identificador AS workflow, ins.nombre_instancia, wfins.proceso");
		$this->db->from("workflow AS wf");
		$this->db->join("instancia_has_workflow AS wfins","wfins.workflow_idworkflow = wf.idworkflow");
		$this->db->join("instancia AS ins","ins.idinstancia = wfins.instancia_idinstancia");
		if(isset($iddoc)){
			$this->db->select("docwf.estado_idestado AS idestado, docwf.idinstancia_has_workflow AS idwfins, docwf.iddocumento_has_workflow AS iddocwf, docwf.fecha_reg"); #docwf.documento_iddocumento AS iddocumento  no se necesita 
			$this->db->join("documento_has_workflow AS docwf","wfins.idinstancia_has_workflow = docwf.idinstancia_has_workflow AND docwf.documento_iddocumento =".$iddoc,"left");
		}
		if (isset($idwf)) {
			$this->db->where("wf.idworkflow",$idwf);
		}
		if(isset($idtp)){
			$this->db->where("wf.tipo_doc_idtipo_doc",$idtp);
		}
		$this->db->order_by('wfins.idinstancia_has_workflow', 'ASC');
		$ret = $this->db->get();
		$this->db->close();
		return $ret;
	}

	public function setInstancia($nombre, $proceso, $idwf){
		$this->load->database();
		$this->db->insert("instancia",array("nombre"=>$nombre, "estado"=>TRUE));
		$this->db->insert("instancia_has_workflow",array("workflow_idworkflow"=>$idwf, "instancia_has_workflow"=>$this->db->insert_id(), "proceso"));
	}


	public function getBy($nombre = NULL, $instancia = NULL)
	{
		$this->load->database();
		$this->db->from("workflow AS wf");
		$this->db->join("tipo_doc As tp","wf.tipo_doc_idtipo_doc = tp.idtipo_doc");
		$this->db->join("instancia_has_workflow As inswf","wf.idworkflow = inswf.workflow_idworkflow");
		if (isset($nombre)) {
			$this->db->where("tp.nombre_tipo",$nombre);
		}
		if(isset($instancia)){
			$this->db->where("inswf.instancia_idinstancia",$instancia);
		}
		$wf = $this->db->get();
		$this->db->close();
		return $wf->row();
	}
}

/* End of file Workflow_db.php */
/* Location: ./application/models/Workflow_db.php */