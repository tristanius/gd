    <style type="text/css">
        #ruta_gestion{
            display: block;
            overflow: hidden;
            margin:1ex;
            border: 1px solid #ddd;        
        }
        #ruta_gestion .ruta_name, #ruta_gestion .ruta_separador{
            float: left;
        }
        #ruta_gestion  .ruta_name{
            padding: 0.8em;
            font-size: 0.8em;
        }
        #ruta_gestion .ruta_separador{		
            height: 2.5em;
        }
        #ruta_gestion .ruta_separador img{
            height: 100%;
        }
    </style>
    <div id="ruta_gestion">
		<div class="ruta_name" data-icon="B"> ¿Donde estoy?:</div>
			<?php
			foreach ($direccion_act as $sec) {
				?>
				<div class="ruta_name"><?php echo $sec ?></div>
				<div class="ruta_separador"><img src="<?php echo base_url("assets/img/separador-ruta2.png"); ?>"></div>
				<?php
			}
			?>
    </div>