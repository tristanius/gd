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
		<header>
			<div class="logo">
				<a href="<?= site_url() ?>"><img src="<?php echo base_url("assets/img/termotecnica.jpg") ?>" /></a>
			</div>
			<div class="menu">
				<ul>
					<li><a href="" data-icon="Z"> Termotecnica Coindustrial S.A.</a></li>
					<li><a href="<?= site_url('notificacion/getmemos') ?>" id="notifis">Correspondencia</a></li>
					<li><a href="" data-icon="j"> Sobre la aplicación web</a></li>
				</ul>
			</div>
		</header>