<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function guardar_log($fech, $actividad, $ip, iduser, $idpersona, $priv, $est = TRUE, $rev = FALSE)
	{
		try {	
			$datos = array(
					'fecha_actividad' => $fech,
					'actividad_realizada' => $actividad,
					'direccion_ip' => $ip,
					'usuario_idusuario' =>$iduser,
					'privilegio_idprivilegio' => $priv,
					'estado' => $est,
					'revisado' => $rev
				);
			$this->db->insert('log_movimientos', $datos);
			return TRUE;
		} catch (Exception $e) {
			return FALSE;
		}
	}

	public function consulta_log_recientes($limit = 20, $indicador = 0)
	{
		try {
			$this->db->select("*");
			$this->db->from("log_movimientos As log");
			$this->db->join("usuario AS user", "log.usuario_idusuario = user.idusuario");
			$this->db->join("privilegio AS priv", "log.privilegio_idprivilegio = priv.idprivilegio");
			$this->db->order_by("log.idlog_movimientos","DESC");
			$this->db->limit($limit, $indicador);
			return $this->db->get();
		} catch (Exception $e) {
			return $e->getMessege();
		}
	}

	public function consulta_by_user($user, $limit=100, $ip=NULL)
	{
		try {
			$this->db->select("*");
			$this->db->from("log_movimientos As log");
			$this->db->join("usuario AS user", "log.usuario_idusuario = user.idusuario");
			$this->db->join("privilegio AS priv", "log.privilegio_idprivilegio = priv.idprivilegio");
			$this->db->where('user.username',$user);
			$this->db->order_by("log.idlog_movimientos","DESC");
			return $this->db->get();
		} catch (Exception $e) {
			return $e->getMessege();
		}
	}

	public function consulta_by_fechas($fecha1, $fecha2, $limit=50, $iduser=NULL)
	{
		try {
			$this->db->select("*");
			$this->db->from("log_movimientos As log");
			$this->db->join("usuario AS user", "log.usuario_idusuario = user.idusuario");
			$this->db->join("privilegio AS priv", "log.privilegio_idprivilegio = priv.idprivilegio");
			$this->db->where('user.username',$user);
			$this->db->order_by("log.idlog_movimientos","DESC");
			return $this->db->get();
		} catch (Exception $e) {
			return $e->getMessege();
		}
	}

	public function consulta_by_privilegio($idpriv, fecha=NULL,$limit=50, $iduser=NULL, $ip=NULL)
	{
		
	}

}

/* End of file  */
/* Location: ./application/models/ */