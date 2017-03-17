<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#Devuelve el estado de un cargo asignado a una persona: aprobado, no aprobado y en espera.
function estado_aprobacion($idcp){#idcp es id del cargo asociado a una persona
	$ci =& get_instance();
	$cps = $ci->db->get_where("aprobacion",array("idpersona_has_cargo"=>$idcp));
	$cp = $cps->row();
	if($cp->isaprobacion){
		return "<span style='color:green'>Aprobado</span>";
	}else{
		return "<span style='color:red'>No aprobado</span>";
	}
}

#Devuelve un boolean si exite (TRUE) o no (FALSE) una aprovacion o desaprobacion
function existe_aprobacion($idcp){ #idcp es id del cargo asociado a una persona
	$ci =& get_instance();
	$cps = $ci->db->get_where("aprobacion",array("idpersona_has_cargo"=>$idcp));
	if($cps->num_rows() >= 1){
		return TRUE;
	}else{
		return FALSE;
	}
}

#obtiene una aprobacion
function get_aprobacion($idcp){ #idcp es id del cargo asociado a una persona
	$ci =& get_instance();
	$cps = $ci->db->get_where("aprobacion",array("idpersona_has_cargo"=>$idcp));
	return $cps->row();
}


function get_estado($idcp){#idcp es id del cargo asociado a una persona
	$ci =& get_instance();
	$cps = $ci->db->get_where("aprobacion",array("idpersona_has_cargo"=>$idcp));
	$cp = $cps->row();
	if($cp->isaprobacion){
		return TRUE;
	}else{
		return FALSE;
	}
}

function getDocumento($id)
{
	$ci =& get_instance();
	$rows = $ci->db->get_where("documento",array("iddocumento"=>$id));
	if($rows->num_rows() > 0){
		$row = $rows->row();
		return $row->ruta;
	}else{
		return "";
	}
}
