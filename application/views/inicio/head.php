	<head>
        <meta charset="utf-8" >
        <meta name="viewport" content="width=device-width initial-scale=1">
        <meta description="Termotecnica Coindustrial S.A. Cúcuta, HUB of webapps.">
        <meta keywords="funcionalidad, termotecnica, termo, documental, reportes diarios">
        <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" />
        <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.1.min.js") ?>"></script>
		
		<link href="<?php echo base_url("assets/fontastic/styles.css") ?>" rel="stylesheet">
		<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.css") ?>" rel="stylesheet" />
		<link href="<?php echo base_url("assets/estilo-gestion.css") ?>" rel="stylesheet" />
        <link href="<?php echo base_url("assets/estilo-principal.css") ?>" rel="stylesheet" />

        
        <!--  ============ plugins =========== -->

        <!-- inicio AJAX UPLOADFILE PLUGIN -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/js/jquery-uploadfile/uploadfile.css") ?>">
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-uploadfile/jquery.form.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-uploadfile/jquery.uploadfile.min.js"); ?>"></script>
		<!-- fin AJAX UPLOADFILE PLUGIN -->

        <!-- Angular -->

        <script type="text/javascript" src="<?php echo base_url("assets/js/angular.min.js"); ?>"></script>
        
        <!-- inicio OFFILE PLUGIN 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/offline/offline-theme.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/offline/offline-indicator-es.css") ?>">
        <script type="text/javascript" src="<?php echo base_url("assets/plugins/offline/offline.min.js"); ?>"></script>
        <script>
            
            Offline.options = {
            }

            var run = function(){
                if (Offline.state === 'up'){
                    Offline.check();
                    $(".gestion-pr").show();
                    $("#offline").hide();
                }else if(Offline.state === 'down'){
                    Offline.check();
                    $(".gestion-pr").hide();
                    $("#offline").show();
                }
                    
            }
            setInterval(run, 100);
        </script>
		<!-- fin OFFLINE PLUGIN -->
		
		<title>Termotecnica: Plataforma de gestion de usuarios.</title>
	</head>