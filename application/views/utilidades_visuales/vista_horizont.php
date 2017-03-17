<?php $this->load->view("utilidades_visuales/ruta_actual",array("direccion_act"=>$direccion_act)) ?>

<div class="gestion-pr">
	<?php echo $vista_pr ?>
</div>

<hr>

<?php $this->load->view("utilidades_visuales/menu",array("menu"=>$menu)) ?>
