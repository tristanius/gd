<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Corrector extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("config");
		if(!$this->mysess()){
			redirect(site_url(""));
		}
		
        date_default_timezone_set("America/Bogota");
	}

	public function index()
	{
		
	}

	public function formModPefil($value='')
	{
		$direccion_act = array(
				'<a href="'.site_url('').'">App GD</a>',
				'<a href="#"">Advanced</a>',
				'<a href="'.current_url('').'">correcion</a>'
			);

		$menu = array(
					array("data-icon='&#xe001'","Volver a vista principal", site_url())
				);
		$this->crear_vista("Administrator/corregir_identificacion", array(), $menu, $direccion_act);
	}


	public function getData()
	{
		$id=$this->input->post('id');
		$this->load->database();
		$rows = $this->db->select('primer_nombre, segundo_nombre, primer_apellido, segundo_apellido')->from('persona')->where('identificacion',$id)->get();
		if ($rows->num_rows() > 0) {
			echo json_encode($rows->row());
		}else{
			echo "failed";
		}
	}

	public function modPerfil($id='')
	{
		$id=$this->input->post('id');
		$id_ant = $this->input->post('id_ant');
		
		$this->crear_directorio("persona/".$id);

		$this->load->database();
		$this->actualizarDocs($id, $id_ant);
		$this->db->update('persona', array('identificacion' => $id), 'identificacion = '.$id_ant);

		#$this->eliminar_arbol("./uploads/persona/".$id_ant);
		
		echo "Success";
	}

	public function actualizarDocs($idp, $idp_ant)
	{
		$this->load->database();
		foreach ($this->getDocsBy($idp_ant) as $key => $value) {
			$nomdoc = $idp.'-'.$value->nombre_tipo.$this->getTipoDoc($value->nombre_documento);

			$this->db->update('documento', array( 'nombre_documento'=>$nomdoc ), 'iddocumento = '.$value->iddocumento);
			rename (
				"./uploads/persona/".$idp_ant."/".$value->nombre_documento, 
				"./uploads/persona/".$idp."/".$nomdoc
				);
		}

		foreach ($this->getAprobacionBy($idp_ant) as $key => $value) {
			$nomdoc = $idp.'-aprobacion_cargo'.$this->getTipoDoc($value->documento);

			$this->db->update('aprobacion', array( 'documento'=>$nomdoc ), 'idaprobacion = '.$value->idaprobacion);
			rename (
				"./uploads/persona/".$idp_ant."/".$value->documento, 
				"./uploads/persona/".$idp."/".$nomdoc
				);
		}
	}


	private function getDocsBy($idp_ant)
	{
		$this->load->database();
		return $this->db->from('documento AS doc')
			->join('persona_has_documento AS docp','doc.iddocumento = docp.documento_iddocumento')
			->join('tipo_doc AS tpdoc','doc.tipo_doc_idtipo_doc = tpdoc.idtipo_doc')
			->where('docp.persona_identificacion',$idp_ant)
			->get()->result();
	}

	private function getAprobacionBy($idp_ant)
	{
		$this->load->database();
		return $this->db->from('aprobacion AS apb')
			->join('persona_has_cargo AS pcar','apb.idpersona_has_cargo = pcar.idpersona_has_cargo')
			->where('pcar.persona_identificacion',$idp_ant)
			->get()->result();
	}

	public function getTipoDoc($val)
	{
		$tipo =  stristr( substr($val, -5), '.');
		switch ($tipo) {
			case '.pdf':
				return $tipo;
				break;
			case '.xlsx':
				return $tipo;
				break;
			case '.docx':
				return $tipo;
				break;
			case '.xls':
				return $tipo;
				break;
			case '.doc':
				return $tipo;
				break;
			default:
				return $tipo;
				break;
		}
		return $tipo;
	}

	private function crear_directorio($dir){
		#rmdir("./uploads/".$dir);
		if (!file_exists("./uploads/".$dir)) {
			mkdir("./uploads/".$dir, 0777);
		}
    }
	# metodo para eliminar el arbol de subdirectorios y archivos
	private function eliminar_arbol($carpeta){
		foreach(glob($carpeta . "/*") as $archivos_carpeta){
			#echo $archivos_carpeta;
			if (is_dir($archivos_carpeta)){
				eliminarDir($archivos_carpeta);
			}else{
				unlink($archivos_carpeta);
			}
		}
		rmdir($carpeta);
	}


	#=================================================================================
	# privados utiles
	#=================================================================================
	public function crear_vista($vista, $data, $menu=NULL, $direccion_act=NULL){

		$html = $this->load->view($vista, $data, TRUE);
		
		$vista = $this->load->view(
				"utilidades_visuales/vista_horizont",
				array(
					"vista_pr"=>$html,					
					"menu"=>$menu,
					"direccion_act"=>$direccion_act
					),
				TRUE );
		$this->load->view("home",array("vista"=>$vista));
	}

	public function mysess($value='')
    {
        $sess = $this->session->userdata("isess");
        if(isset($sess) && $sess != NULL && $sess != "")
            return TRUE;
        else
            return FALSE;
    }

}

/* End of file Corrector.php */
/* Location: ./application/models/Corrector.php */