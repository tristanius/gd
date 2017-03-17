	<head>
        <meta charset="utf-8" >
        <!--[if lt IE 9]>
		<script src="<?php echo base_url("assets/js"); ?>/html5.js"></script>
		<![endif]-->

        <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" />
		<link href="<?php echo base_url("assets/fontastic/styles.css") ?>" rel="stylesheet">
		<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css") ?>" rel="stylesheet" />
		<link href="<?php echo base_url("assets/estilo-gestion.css") ?>" rel="stylesheet" />
        <link href="<?php echo base_url("assets/estilo-principal.css") ?>" rel="stylesheet" />

		<script type="text/javascript" src="<?php echo base_url("assets/js/angular.min.js"); ?>"></script>
	    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.1.min.js") ?>"></script>
	    
	    <script src="<?php echo base_url("assets/js/jquery-ui/jquery-ui.js") ?>"></script>
	    <link rel="stylesheet" href="<?php echo base_url("assets/js/jquery-ui/jquery-ui.css") ?>">
	    <script type="text/javascript">
	    $.datepicker.regional['es'] ={
			closeText: 'Cerrar',
			prevText: 'Previo',
			nextText: 'Próximo',			 
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
			'Jul','Ago','Sep','Oct','Nov','Dic'],
			monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
			dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			initStatus: 'Selecciona la fecha', isRTL: false
		};

		$.datepicker.setDefaults($.datepicker.regional['es']);
	    </script>

	    <!--  ============ plugins =========== -->

    <!-- inicio AJAX UPLOADFILE PLUGIN -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/jquery-uploadfile/uploadfile.css') ?>">
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-uploadfile/jquery.form.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-uploadfile/jquery.uploadfile.min.js"); ?>"></script>
		<!-- fin AJAX UPLOADFILE PLUGIN -->

		<script type="text/javascript" src="<?php echo base_url("assets/plugins/datatables/datatables.min.js"); ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datatables/datatables.min.css') ?>">

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

		<title>Termotecnica: Plataforma de reportes diarios.</title>
	</head>
