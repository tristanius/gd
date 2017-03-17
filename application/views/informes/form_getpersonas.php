
		<div class="texto-normal panel">
			<h1>Informes y reportes<small></small></h1>
			<hr>

			<p>
				Seleccione un tipo de consulta para generar el reporte,
			este puede ser visualizado en la web o en generado en un archivo .XLS,
				ste ultimo puede ser abierto desde un archiv de excel.
			</p>

			<div id="botonera">
				<?php
		    $priv = $this->session->userdata("privilegios");
		    if ( isset( $priv->{36} ) ) {
		    ?>
				<button data-link="<?= site_url('informe/cargar_form/form_by_cargo')?>" class="btn btn-primary">Informe por general</button>
				<button data-link="<?= site_url('informe/cargar_form/form_by_estado')?>" class="btn btn-primary">Informe por estado de aprobacion</button>
			<?php
			}
			?>
				<button data-link="<?= site_url('informe/cargar_form/form_by_lista')?>"  class="btn btn-primary">Informe Personas por lista de C.C. </button>
			<?php
			if ( isset( $priv->{35} ) ) {
			?>
				<button data-link="<?= site_url('informe/cargar_form/form_by_uploaded/'.$this->session->userdata('base_idbase')) ?>"  class="btn btn-primary">Personas cargadas desde tu base </button>
			<?php
			}
			?>
			</div>

			<hr class="clearfix">


			<div id="formulario" style="background:#EFEFEF; padding:1ex;"></div>

		</div>
		<br>

		<script type="text/javascript">
		function getView(url) {
			$("#formulario").load(url);
		}

		$(document).ready(function(){
			$("#botonera button").on("click",function(){
				getView($(this).data("link"));
			})
		});
		</script>
