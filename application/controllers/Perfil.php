<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of test
 *
 * @author Yeison
 */

class Perfil extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/Bogota");
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
		header('Pragma: no-cache'); // HTTP 1.0
		header('Expires: 0'); 
		$this->load->helper("config");
		$this->load->helper("cargos");
		if(!$this->mysess())
			redirect(app_termo());
	}

	public function index(){
		$this->form_add_perfil();
	}

	#===================================================================================================================
	#Paso 1: Validacion de ID
	public function form_valid_id($val = FALSE){
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('perfil')."'>Add. hoja de vida y cargos del perfil</a>",
				"Paso 1: Validadcion de identidad"
			);
		echo $this->crear_view("perfil_profesional/form_valid_id", $this->menu(FALSE,TRUE), $direccion_act,array("err"=>$val));
	}
	public function comfir_valid_id(){
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('perfil')."'>Add. hoja de vida y cargos del perfil</a>",
				"Paso 1.1: ¿Confirma No. identidad?"
			);
		$id = $this->input->post("cc");
		echo $this->crear_view("perfil_profesional/form_valid_id2", $this->menu(FALSE,TRUE), $direccion_act,array("idper"=>$id));
	}

	public function validar_id(){
		$cc = $this->input->post("cc");
		$cc2 = $this->input->post("cc2");
		if($cc != $cc2)
			redirect(site_url("perfil/form_valid_id/TRUE"));

		if($this->existe_persona($cc)){
			redirect(site_url('perfil/ver/'.$cc));
			return false;
		}

		#$id = preg_replace("/\.|,|\s/", "", $cc);
		$id = preg_replace("/\.|,/", "", $cc);
		$this->session->unset_userdata('persona');
		try {
			$this->load->database();
			$this->load->model("persona_db");
			$personas = $this->persona_db->get_persona($id);
			#cargamos la sesion para envio de parametros
			$this->load->library("session");#tener cuidado con los datos de session de usuario
			$this->session->set_userdata("persona",array("idper"=>$id));
			if($personas->num_rows() <= 0 ){
				redirect(site_url("perfil/form_add_perfil/"));
			}
			else{
				redirect(site_url('perfil/ver/'.$id));
			return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	#====================================================================================================================
	#Paso 2: Subir archivo y registrar


	public function form_add_doc_type($idper,$add=NULL){
		$this->load->database();
		$this->load->view("perfil_profesional/actualizar/form_add_doc_type",array("idper"=>$idper,"add"=>$add));
	}

	public function upload_doc($id){
		try {
			$this->crear_directorio($id);
			$config['upload_path'] = './uploads/'.$id;
			$config['allowed_types'] = '*';
			$config['file_name'] = $id;
			$this->load->library("upload",$config);
			if($this->upload->do_upload("file")){
				$data = $this->upload->data();
				$regis = $this->registrar_doc($id, $data['file_name']);
				if ($regis == FALSE) {
					echo "error al insertar en la base de datos";
				}else{
					echo "Exito! la insercion esta completada ";
				}
			}else{
				echo "algo ha fallado :( ". $this->upload->display_errors();
			}
		} catch (Exception $e) {
			echo $e->getMessege();
		}
	}

	public function upload_doc_type($id)
	{
		$this->upload_doc_type($id);
	}
	public function upload_doc_type_add($id)
	{
		try {
			$type = $this->input->post("tipo");
			$user = $this->input->post("resu");
			$base = $this->input->post("base");

			$mitipo = tipo($type);
			$otro = "";
			if ($type == "contrato" || $type == "otro") {
				$otro = "_".$this->input->post('otro');
			}
			$this->crear_directorio("persona/".$id);

			$config['upload_path'] = './uploads/persona/'.$id;
			$config['allowed_types'] = '*';
			$config['file_name'] = $id."-".$mitipo.$otro;
			$this->load->library("upload",$config);

			if($this->upload->do_upload("file")){
				$data = $this->upload->data();
				$regis = $this->registrar_doc($data['file_name'],$type, $config['upload_path'], $base, $user);
				if ($regis == FALSE) {
					echo "error al insertar en la base de datos";
				}else{
					$this->addpersona_doc($id, $regis, $base, $user);
					echo "Archivo ".$data['file_name']." - Exito! la insercion esta completada ".$user." ".$base;
				}
			}else{
				echo "algo ha fallado :( ". $this->upload->display_errors();
			}
		} catch (Exception $e) {
			echo $e->getMessege()." - test";
		}
	}

	# metodo para crear el directorio donde debe estar el archivo (si existe previo se elimina primero)
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

	# Aqui registramos en la base de datos el archivo que se subio y a quien pertenece

	private function registrar_doc($nombre, $tipo = "hoja de vida", $ruta, $base = NULL, $usuario = NULL){
		try {
			$this->load->database();
			$this->load->model("documento_db");
			return $this->documento_db->insert_doc($nombre, $tipo, $ruta."/".$nombre, $base, $usuario);
		} catch (Exception $e) {
			return false;
		}
	}
	private function addpersona_doc($idper, $iddoc, $base_idbase, $user )
	{
		$this->load->database();
		if ($this->db->get_where("persona",array("identificacion"=>$idper))->num_rows() == 0 ) {
			$this->db->insert("persona",array("identificacion"=>$idper, 'base_creacion'=>$base_idbase, "usuario_creacion"=>$user ));
		}
		$this->db->insert('persona_has_documento', array("persona_identificacion"=>$idper, "documento_iddocumento"=>$iddoc));
	}
	#====================================================================================================================
	#Paso 3: add. perfil

	public function form_add_perfil($id=NULL){
		$sesper = $this->session->userdata("persona");
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('perfil')."'>Add. hoja de vida y cargos del perfil</a>",
				"<a href='".site_url("perfil/form_add_perfil/".$sesper["idper"])."'>Paso 2: Registro de perfil</a>"
			);
		if(isset($sesper["idper"]) || $sesper["idper"] != "")
			$datos["idper"] = $sesper["idper"];
		elseif(isset($id))
			$datos["idper"] = $id;
		else
			redirect(site_url());
		echo $this->crear_view("perfil_profesional/form_add_perfil", $this->menu(FALSE,TRUE), $direccion_act, $datos);
	}


	public function add_perfil(){
		$id = $this->input->post("idper");
		$nom1 = $this->input->post("nom1");
		$nom2 = $this->input->post("nom2");
		$ape1 = $this->input->post("ape1");
		$ape2 = $this->input->post("ape2");

		$esco = $this->input->post("escolaridad");
		$titulo = $this->input->post("titulo");
		$mobra = $this->input->post("mobra_local");

		$user = $this->input->post("resu");
		$base = $this->input->post("base");

		$nocargos = $this->input->post("no_cargos");
		addlog($this->input->ip_address(), "Creado nuevo perfil con C.C. ".$id, 32, $this->session->userdata('idusuario'));
		$this->load->database();
		$this->load->model("persona_db");
		try {
			$ret = $this->persona_db->modificar_datos($id, $nom1, $nom2, $ape1, $ape2, $esco, $titulo, $mobra, $this->session->userdata('base_idbase'), $this->session->userdata("idusuario"));
			if ($ret == FALSE) {
				echo "Error fatal al intentar insertar en la base de datos, vuelva a intentarlo en un momentos.";
			}else{
				$this->relacionar_cargos($nocargos, $id, $this->session->userdata('base_idbase'), $this->session->userdata("idusuario"));
			}
		} catch (Exception $e) {
			echo "Error fatal al intentar insertar en la base de datos, vuelva a intentarlo en un momentos.";
		}
		redirect(site_url("perfil/ver/".$id));
	}

	#Relaciona los cargos de un perfil
	private function relacionar_cargos($nocargos, $id, $base=NULL, $usuario=NULL){
		$band = FALSE;
		for ($i=1; $i <= $nocargos; $i++) {
			$codcargo = $this->input->post("codcargo".$i);
			$ret2 = $this->persona_db->insert_persona_x_cargo($id, $codcargo, $base, $usuario);
			if(!$ret2){
				addlog($this->input->ip_address(), "Add. Cargo id:".$codcargo." con C.C. ".$id, 21, $usuario );
				$band = TRUE;
			}
		}
		return $band;
	}

	public function form_add_cargo(){
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('perfil')."'>Paso 1: Add. hoja de vida y cargos del perfil</a>",
				"<a href='".site_url("perfil/form_add_perfil/".$sesper["idper"])."'>Paso 2: Registro de perfil</a>",
				"Paso 3: Asignacion de cargos (final)"
			);
		$sesper = $this->session->userdata("persona");
		$datos["idper"] = $sesper["idper"];
		echo $this->crear_view("perfil_profesional/form_add_cargos", $this->menu(FALSE,TRUE), $direccion_act, $datos);
	}

	public function form_add_curso($idper)
	{
		$this->load->view("perfil_profesional/actualizar/form_add_curso",array("idper"=>$idper));
	}
	public function addCurso($idper)
	{
		$nom = $this->input->post('nombre_curso');
		$fecha = date("Y-m-d", strtotime( $this->input->post('fecha_exp') ) );
		$vigencia = date("Y-m-d");
		if( $nom == 'LICENCIA DE CONDUCCIÓN'){
			$vigencia = date('Y-m-d', strtotime('+3 year', strtotime($this->input->post('fecha_exp'))  ) );
		}else{
			$vigencia = date('Y-m-d', strtotime('+1 year', strtotime($this->input->post('fecha_exp'))  ) );
		}

		$this->load->database();
		$this->load->model("Persona_db","per");
		$bandera = $this->per->addCurso($idper, $nom, $fecha, $vigencia);
		if ($bandera) {
			redirect(site_url('perfil/form_modificar/'.$idper),'refresh');	
		}else{
			echo "Error al guardar el la BD.";
		}
	}

	public function delete_curse($idper, $idcurso)
	{
		$this->load->database();
		$this->db->delete('curso', array("idcurso"=>$idcurso));
		redirect(site_url('perfil/form_modificar/'.$idper),'refresh');
	}

	public function form_add_new_cargo($idper, $item = NULL){
		$this->load->database();
		$this->db->order_by('nombre', 'ASC');
		$cargos = $this->db->get("cargo");
		echo $this->load->view("perfil_profesional/form_add_new_cargo",
					array("idper"=>$idper, "item"=>$item, "cargos"=>$cargos),
					TRUE);
	}

	#=====================================================================================================================
	#ver un perfil
	public function ver($idper=NULL){
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('consulta')."'>Consulta: hoja de vida y cargos del perfil</a>",
				"Vista de hoja de vida de persona"
			);
		$this->load->database();
		$this->load->model("documento_db");
		$this->load->model("persona_db");
		$this->load->model("cargo_db");
		$pers = $this->persona_db->get_persona_id($idper);
		$cargos = $this->cargo_db->get_cargos_per($idper);
		$cursos = $this->persona_db->get_cursos_persona($idper);
		$docs = $this->documento_db->get_total_docs_persona($idper);
		if($docs == FALSE || $pers == FALSE){
			echo "Datos no encontrados en la base de datos";
			return FALSE;
		}else{
			$data = array('docs' => $docs, "per"=>$pers->row(), "cargos"=>$cargos, "cursos"=>$cursos);
			echo $this->crear_view("consultas/ver",$this->menu(FALSE,TRUE), $direccion_act, $data);
		}
	}


	#======================================================================================================================
	#modificar un perfil
	public function form_modificar($idper)
	{
		#validar session y usuario OJO!!
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url('perfil/ver/'.$idper)."'>ver perfil</a>",
				"<a href='".current_url()."'>modificar</a>"
			);
		$this->load->database();
		$this->load->model("documento_db");
		$this->load->model("persona_db");
		$this->load->model("cargo_db");
		$pers = $this->persona_db->get_persona_id($idper);
		$cargos = $this->cargo_db->get_cargos_per($idper);
		$cursos = $this->persona_db->get_cursos_persona($idper);
		$docs = $this->documento_db->get_total_docs_persona($idper);
		if($docs == FALSE || $pers == FALSE || $pers->num_rows() == 0){
			echo "Datos no encontrados en la base de datos, <a href='".site_url()."'>click aqui para volver.</a>";
			return;
		}
		try {
			$persona = array('docs' => $docs, "per"=>$pers->row(), "cargos"=>$cargos, "idper"=>$idper, "cursos"=>$cursos);
			$vista_ver = $this->load->view("perfil_profesional/actualizar/ver_actualizar", $persona, TRUE);
			$data = array("per"=>$pers->row(), "vista_ver"=>$vista_ver, "idper"=>$idper);
			echo $this->crear_view("perfil_profesional/actualizar/form_actualizar",
					$this->menu(FALSE,TRUE),
					$direccion_act,
					$data
				);
		} catch (Exception $e) {
			echo $e->getMessege();
		}

	}

	public function modificar_datos_persona($id=NULL)
	{
		try {
			$idper = $this->input->post("idper");
			$nom1 = $this->input->post("nom1");
			$nom2 = $this->input->post("nom2");
			$ape1 = $this->input->post("ape1");
			$ape2 = $this->input->post("ape2");

			$esco = $this->input->post("escolaridad");
			$titulo = $this->input->post("titulo");
			$mobra = $this->input->post("mobra_local");

			$this->load->database();
			$this->load->model("persona_db");
			if($this->persona_db->modificar_datos($idper, $nom1, $nom2, $ape1, $ape2, $esco, $titulo, $mobra, $this->session->userdata('base_idbase') ) ){
				addlog($this->input->ip_address(), "Modificado perfil con C.C. ".$id, 32, $this->session->userdata('idusuario'));
				redirect(site_url('perfil/form_modificar/'.$idper));
			}else{
				echo "Algo ha fallado. Ponte en contacto con el Dto. de sistemas.";
			}
			#retornamos al fomrulario de edicion
		} catch (Exception $e) {
			echo $e->getMessege();
		}
	}

	public function agregar_cargo_persona($id=NULL)
	{
		try {
			$this->load->database();
			$this->load->model("persona_db");
			$idp = $this->input->post("id");
			$usuario = $this->input->post("resu");
			$base = $this->input->post("base");
			$ret = $this->relacionar_cargos(1,$idp, $base, $usuario);
			if($ret){
				echo "operacion realizada con exito";
			}else
				echo "Fallo de base de datos";
		} catch (Exception $e) {
			echo $e->getMessege();
		}
	}
	#======================================================================================================================
	#Eliminar un cargo
	public function form_del_cargo($idcp, $ced)
	{
		$direccion_act = array(
				"<a href='".site_url()."'>App. gd</a>",
				"<a href='".site_url("perfil/form_modificar/".$ced)."'>Editar perfil</a>",
				"<a href='".current_url()."'>Borrar cargo</a>"
			);
		$html = "<a class='btn btn-danger' href='".site_url('perfil/del_cargo/'.$idcp."/".$ced)."'> Confirmar borrado de cargo para C.C. ".$ced."</a>";
		$html .= "<br><br><a class='btn btn-default' href='".site_url("perfil/form_modificar/".$ced)."'> << Volver</a>";
		$vista = $this->load->view(
					"utilidades_visuales/vista_horizont",
					array(
						"direccion_act"=>$direccion_act,
						"menu"=>array(array("data-icon='&#xe001'","Volver a vista principal", site_url())),
						"vista_pr"=>$html
						),
					TRUE
				);
		$this->load->view("home",array("vista"=>$vista));
	}

	public function del_cargo($idcp,$ced)
	{
		$this->load->database();
		$rows = $this->db->get_where("aprobacion",array("idpersona_has_cargo"=>$idcp));
		if($rows->num_rows() <= 0){
			$this->db->delete("persona_has_cargo",array("idpersona_has_cargo"=>$idcp));
			redirect(site_url('perfil/ver/'.$ced),'refresh');
		}else{
			$direccion_act = array(
					"<a href='".site_url()."'>App. gd</a>",
					"<a href='".site_url("perfil/form_modificar/".$ced)."'>Editar perfil</a>",
					"<a href='".current_url()."'>Borrar cargo</a>"
				);
			$html = "<p>Accion no permitida, hay una aprobacion relaciona con el cargo.</p> <br><br><a class='btn btn-default' href='".site_url("perfil/ver/".$ced)."'> << Volver</a>";
			$vista = $this->load->view(
						"utilidades_visuales/vista_horizont",
						array(
							"direccion_act"=>$direccion_act,
							"menu"=>array(array("data-icon='&#xe001'","Volver a vista principal", site_url())),
							"vista_pr"=>$html
							),
						TRUE
					);
			$this->load->view("home",array("vista"=>$vista));
		}
	}

	#======================================================================================================================
	#busca todos los perfiles incompletos
	function incompletos(){
		$this->load->database();
	}

	#======================================================================================================================
	#busca todos los perfiles inconclusos
	#estos perfiles inconclusos son auqellos que aun tienen cargos en espera.
	#un perfil inconcluso es aquel que puede no estar completo o con cargos en espera
	public function inconclusos(){

	}


	#====================  BUSCAR =================================================================================================

	#Busqueda de perfil by identificacion
	private function existe_persona($idper =''){
		try {
			$this->load->database();
			$this->load->model("persona_db");
			return $this->persona_db->existe_persona($idper);
		} catch (Exception $e) {
			echo "error al consultar la base de datos";
		}
	}

	#=====================================================================================================================
	# BORRAR UN DOCUMENTO DE UN PERFIL
	public function confirDelDocPerfil($iddoc, $idpersona)
	{
		$direccion_act = array(
				"App. gd",
				"Borrado de archivos importantes"
				);
		$priv = $this->session->userdata("privilegios");

		if( isset($priv->{25}) ){
			$var = "Confirma que desea eliminar este documento?, todo los cambios quedaran registrados como medida de control.";
			$var .= "<a href='".site_url('perfil/delDocPefil/'.$iddoc."/".$idpersona)."' class='btn btn-danger'>Si, Borrar</a>";
			$vista = $this->load->view(
				"utilidades_visuales/vista_horizont",
				array(
					"direccion_act"=>$direccion_act,
					"menu"=>$this->menu(FALSE,TRUE),
					"vista_pr"=>$var
					),
				TRUE
				);
			$this->load->view("home",array("vista"=>$vista));
        }
	}

	public function delDocPefil($iddoc, $idpersona)
	{
		$priv = $this->session->userdata("privilegios");
        if( isset($priv->{25}) ){
        	$this->load->database();
        	$doc = $this->db->get_where("documento",array("iddocumento"=>$iddoc))->row();

        	addlog($this->input->ip_address(), "Borrando documento ".$doc->nombre_documento." del perfil con C.C. ".$idpersona, 25, $this->session->userdata('idusuario'));

        	unlink($doc->ruta);
        	$this->db->delete("persona_has_documento", "documento_iddocumento = ".$iddoc );
        	$this->db->delete("documento", "iddocumento = ".$iddoc);
        }
        redirect(site_url("perfil/ver/".$idpersona),'refresh');
	}

	#=====================================================================================================================
	#=====================================================================================================================
	#utiles y privados generales
	#=====================================================================================================================
	#=====================================================================================================================
	private function crear_view($vista_pr, $menu, $direccion_act, $datos=NULL, $return = FALSE){
		$vista_pr = $this->load->view($vista_pr, $datos,TRUE);
		$vista = $this->load->view(
				"utilidades_visuales/vista_horizont",
				array(
					"direccion_act"=>$direccion_act,
					"menu"=>$menu,
					"vista_pr"=>$vista_pr
					),
				TRUE
				);
		if($return)
			$home = $this->load->view("home",array("vista"=>$vista),TRUE);
		else
			$this->load->view("home",array("vista"=>$vista));
	}

	private function menu($prin = TRUE, $back = FALSE){
		$menu = array();
		if($prin){
			$menu = array(
					array("data-icon='%'","Agregar nueva hoja de vida y cargos",site_url("perfil/form_add_perfil")),
					array("data-icon='8'","Gestión de hojas de vida y cargos.", site_url("perfil/form_gestion_perfiles")),
					array("data-icon='D'","Consultas consultas de perfiles", site_url("perfil/form_consulta_avanzada"))
				);
		}
		else if($back){
			$menu = array(
					array("data-icon='&#xe001'","Volver a vista principal", site_url())
				);
		}
		return $menu;
	}

	public function eliminar_no_regs()	{
		$this->load->database();
		$docs = $this->db->get("documento");
		foreach ($docs->result() as $doc) {
			$per = $this->db->get_where("persona",array("identificacion"=>$doc->persona_identificacion));
			if($per->num_rows()  <= 0)
				$this->db->delete("documento",array("persona_identificacion"=>$doc->persona_identificacion));
		}
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

/* End of file  */
/* Location: ./application/controllers/ */
