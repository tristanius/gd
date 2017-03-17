<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function config_upload($nombre="termo"){

}
function app_termo($app="app.termo"){
	$ci =& get_instance();
	$config['hostname'] = "localhost";
	$config['username'] = "root";
	$config['password'] = "mysql";
	$config['database'] = "app.termo";
	$config['dbdriver'] = "mysql";
	$config['dbprefix'] = "";
	$config['pconnect'] = FALSE;
	$config['db_debug'] = TRUE;
	$db2 = $ci->load->database("app1",TRUE);
	$res = $db2->get_where("aplicacion","nombre_app = '".$app."'");
	$r = $res->row();
	return $r->ruta_app;
}

function addlog($ip, $accion, $privilegio, $user){
	$data["direccion_ip"] = $ip;
	$data["actividad_realizada"] = $accion;
	$data["privilegio_idprivilegio"] = $privilegio;
	$data["usuario_idusuario"] = $user;
	$data["fecha_actividad"] = date("Y-m-d H:i:s a");
	$ci =& get_instance();
	$bd = $ci->load->database("app1",TRUE);
	$bd->insert("log_movimientos",$data);
}

function redir($value='')
{
	redirect(app_termo());
}


function tipo($idtipo){
	$ci =& get_instance();
	$ci->load->database();
	$rt = $ci->db->get_where("tipo_doc", array("idtipo_doc"=>$idtipo));
	if ($rt->num_rows() > 0) {
		$r = $rt->row();
		return $r->nombre_tipo;
	}
	return "";
}

function getUser($id)
{
	$ci =& get_instance();
	$ci->load->database();
	$rt = $ci->db->get_where("app.usuario", array("idusuario"=>$id));
	if ($rt->num_rows() > 0) {
		$r = $rt->row();
		return $r->nombres." ".$r->apellidos;
	}
	return "";
}
