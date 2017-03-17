
<link rel="stylesheet" href="<?php echo base_url('assets/estilo-panel.css') ?>">
<?php $this->load->view("utilidades_visuales/ruta_actual",array("direccion_act"=>$direccion_act)) ?>
<section class="cuerpo-pr">
    <?php 
        if(isset($menu)){
            $this->load->view("utilidades_visuales/menu",array("menu"=>$menu, "selected"=>$selected)) ;
        }	
    ?>

    <div class="gestion-pr<?php echo isset($menu)?"2":""; ?>">
        <?php echo $vista_pr ?>
    </div>

    <hr>
</section>