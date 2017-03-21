
<html>
	<head>
        <meta charset="utf-8" >
        <!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" />

		<link href="<?php echo base_url("assets/fontastic/styles.css") ?>" rel="stylesheet">
		<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css") ?>" rel="stylesheet" />
        <link href="<?php echo base_url("assets/estilo-principal.css") ?>" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.1.min.js") ?>"></script>

        <!-- Gestión de notificaciones via ajax -->
		<script type="text/javascript">
			function checknew(){
				$.ajax({
					url: "<?= site_url('notificacion/checkmemo') ?>",
					success: function(data){
						if(parseInt(data) > 0){
							$("#notifis").text(" Tienes un mensaje nuevo");
							$("#notifis").css({background: "#ff5555", color: "#FFF"});
						}else{
							$("#notifis").text(" No hay mensajes nuevos");
							$("#notifis").css({background: "#FFF", color: "#3A6EE3"});
						}
					}
				});
			}
			$(document).ready(function(){
				setInterval(checknew, 3000);
			});
		</script>

		<title>Termotecnica: Plataforma de gestión de documentos.</title>
	</head>
	<body>
		<header>
			<div class="logo">
				<a href="<?= app_termo() ?>"><img src="<?php echo base_url("assets/img/termotecnica.jpg") ?>" /></a>
			</div>
			<div class="menu">
				<ul>
					<li><a href="<?= site_url('notificacion/getmemos')?>" data-icon='"'  id="notifis"> notificaciones</a></li>
					<li><a href="<?= site_url('principal/manual') ?>" class="icon-question" > Manual </a></li>
					<li><a href="<?= site_url("welcome/redir") ?>" class="icon-user"> Sesión</a></li>
				</ul>
			</div>
		</header>
		<hr class="hr-termo">
		<?php $this->load->view("utilidades_visuales/ruta_actual", array("direccion_act"=>$direccion_act))?>
		<section class="cuerpo-pr">
			<h2 data-icon="8"> Gestion de documentos y archivos</h2>
			<a href="<?= app_termo() ?>" class="btn btn-default" style="text-shadow: none"> << Volver a panel de inicio</a>
			<!-- gestiones -->
			<hr class="termo">


			<div class="diver-mid-con">
				<div class="col-sm-5 diver-mid">
					<h4 class="bg-info rounded">Pefiles:</h4>
					<?php
					#gestion de privilegios
					$priv = $this->session->userdata("privilegios");
					if (isset($priv->{20}) ) {
					?>
					<span data-icon="%"></span>
		            <a href="<?php echo site_url("perfil/form_valid_id") ?>" class="btn btn-success" data-icon="'">
		                Agregar persona y/o Validar cédula.
		            </a>
					<?php
					}
					?>

					<br>
		            <br>
		            <?php
		            if (isset($priv->{26}) || isset($priv->{27}) || isset($priv->{28}) || isset($priv->{30}) || isset($priv->{23})) {
					?>
					<span data-icon="D"></span> <a href="<?php echo site_url("consulta/form_consulta_avanzada") ?>" class="btn btn-info" data-icon="&#xe004;">
		                Consultas Hoja de vida / cargo
		            </a>
					<?php
					}else{
						echo "<p>No puedes acceder a estas funcionalidades.</p>";
					}
					?>
				</div>

				<div class="col-sm-5 diver-mid">
					<h4 class="bg-info rounded">Validacion avanzada:</h4>
					<?php
					if (isset($priv->{1}) || isset($priv->{60})) {
					?>
							<span data-icon="7"></span>
							<a href="<?php echo site_url("corrector/formModPefil") ?>" class="btn btn-primary" data-icon="~">
								Corregir personal
							</a>
					<?php
					}else{
						echo "<p>No puedes acceder a estas funcionalidades.</p>";
					}
					?>
				</div>
			</div>

			<br class="clearfix">

			<hr>

            <br style="clear:left">
			<!-- gestiones -->
			<hr style="clear:left"/>

			<div class="good-will">
				¿No estas familiarizado esta aplicación web?
				<a href="" class="btn btn-success">Si es así, le invitamos a que Ingresa aquí.</a>
			</div>
		</section>

		<?php $this->load->view('principal/user_reg', array()); ?>
        <hr class="hr-gray">
		<footer>
            <p>Todos los derechos reservados a Termotecnica Coindustrial S.A. Ingenieros Contratista.</p>
            <p>Dpto. de Sistemas, Cúcuta</p>
            <p>Año 2014</p>
		</footer>

	</body>
</html>
