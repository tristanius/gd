<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of test
 *
 * @author Yeison
 */
class Principal extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("America/Bogota");
        $this->load->helper("config");
        if(!$this->mysess()){
            redirect(app_termo());
        }
    }

    function index(){
        $this->inicio();
    }
    public function inicio(){
        $direccion_act = array("<a href='".site_url("")."'>App gd</a>","Aplicacion para hojas de vida y perfiles | termotecnica");
        $this->load->view('principal/indice', array("direccion_act"=>$direccion_act));
    }

    public function directorio($dir){
        mkdir("./uploads/".$dir, 0777);
    }

    public function directorioUp(){
        mkdir("./uploads", 0777);
    }
    
    public function test(){
        echo "test";
    }

    public function manual($value='')
    {
        $direccion_act = array(
                "<a href='".site_url()."'>App. gd</a>",
                "<a href='".current_url()."'>Manuales</a>",
            );
        $this->myview("manuales/menu",$direccion_act);
    }

    public function mysess($value='')
    {
        $sess = $this->session->userdata("isess");
        if(isset($sess) && $sess != NULL && $sess != "")
            return TRUE;
        else
            return FALSE;
    }


    private function myview($vista_pr, $direccion_act, $datos=NULL, $return = FALSE){
        $vista_pr = $this->load->view($vista_pr, $datos,TRUE);
        $menu = array(
                    array("data-icon='&#xe001'","Volver a vista principal", site_url())
                );
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



    public function setMovs()
    {
        $this->load->database();

        $personas = $this->db->get("persona");
        $pers2 = $this->db->get("persona");
        $pers3 = $this->db->get("persona");
        $i = 0;
        /*
        foreach ($personas->result() AS $p) {
            echo $this->db->update("persona",array("base_creacion"=>$p->base_idbase), "identificacion = ".$p->identificacion)." ";
            $i++;
            echo $i." ".$p->base_idbase." <br>";
        }
        foreach ($pers2->result() as $p2) {
            $this->db->update("documento",array("base_creacion"=>$p2->base_idbase), "iddocumento = ".$p2->iddocumento);
        }*/

        foreach ($pers3->result() as $p3) {
            $this->db->update("persona_has_cargo",array("base_creacion"=>$p3->base_idbase), "persona_identificacion = ".$p3->identificacion);            
        }
    }

}

/* End of file  */
/* Location: ./application/controllers/ */