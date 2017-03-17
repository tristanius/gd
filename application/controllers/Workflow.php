<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workflow extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/Bogota");
	}

	public function index()
	{

	}
		
  #=================================================================================================
  #Obtiene un wf de un documento JSON
  	public function get_by_tp($idtp, $iddoc=NULL)
	{
		$this->load->model("workflow_db");
		if(isset($iddoc) && $iddoc == "null")
			$iddoc= NULL;
		$this->load->database();
		$dws = $this->db->get_where("documento_has_workflow", array("documento_iddocumento"=>$iddoc));
		if($dws->num_rows() == 0)
			$iddoc = NULL;
		$rows = $this->workflow_db->get(NULL, $idtp,$iddoc);
		echo json_encode($rows->result());
	}
	#
	##actualizar ina instancia de un documento
	## DEBE ENVIARSE POR POST UNA URL A LA CUAL REGRESAR
	public function up_est($iddw=NULL)
	{
		$iddoc = $this->input->post("iddoc");
		$idest = $this->input->post("idest");
		$idwf = $this->input->post("idwf");
		$this->load->database();
		
		if(isset($iddw) && $iddw != "null"){
			$this->db->update("documento_has_workflow", array("estado_idestado"=>$idest, "fecha_reg"=>date("Y-m-d")), "iddocumento_has_workflow = ".$iddw);
			echo "actualizado";
		}else{
			$this->db->insert("documento_has_workflow",array("documento_iddocumento"=>$iddoc, "fecha_reg"=>date("Y-m-d"), "estado_idestado"=>$idest, "idinstancia_has_workflow"=>$idwf));
			echo "insertado";
		}
		redirect($this->input->post("myurl"));
	}

	public function state($iddoc)
	{
		$band = TRUE;
		$this->load->model("documento_db");
		$this->load->model("workflow_db");
		$docwfs = $this->workflow_db->get(NULL, NULL, $iddoc);
		$docins = $this->documento_db->getDataWf($iddoc);
		if($docwfs->num_rows() == $docins->num_rows()){
			if($docins->num_rows() == 0){
				$band = FALSE;
			}else{
				foreach ($docins->result() as $row) {
					if($row->nombre_estado != "Completado"){
						$band = FALSE;
					}
				}
			}
		}else{
			$band = FALSE;
		}

		if($band)
			echo 1;
		else
			echo 0;
	}

	
}
/* End of file workflow.php */
/* Location: ./application/controllers/workflow.php */
