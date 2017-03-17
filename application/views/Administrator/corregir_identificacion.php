<style type="text/css">
	.nodisplay{
		display: none;
	}
</style>

<article class="" style="text-align: left">
	
	<form id="myform">
		
		<fieldset>
			<legend>Cambio de cedula</legend>
			
			<div>
				<label>Identificacion anterior :</label>
				 <input type="text" id="identificacion" name="identificacion">
			</div>

			<button class="btn btn-success" type="submit"> Buscar </button>

		</fieldset>

	</form>

	<div id="resultado" class="nodisplay">
		<div id="resultado-info">

		</div>
	</div>
	<br>

	<form id="myform2" action="<?= site_url('corrector/modPerfil') ?>" method="post" class="nodisplay">
		<fieldset>
			<label>Nueva identificacion: </label> 
			<input type="text" id="id" name="id">

			Por : <input type="text" id="id_ant" name="id_ant" readonly="">

			<button class="btn btn-warning" type="submit"> Buscar </button>
		</fieldset>
	</form>

</article>


<script type="text/javascript">
	$(document).ready(function(){
		$("form#myform").submit(function(e){
			e.preventDefault();
			$.post('<?= site_url("corrector/getData/") ?>', {id: $("#identificacion").val() })
			.done(function(data){
				$("#resultado").toggleClass("nodisplay");
				$("#resultado-info").html(data);
				$("#myform2").toggleClass("nodisplay")
				$("#id_ant").val($("#identificacion").val());
			})
			.fail(function(data){
				console.log(data.responseText);
				$("#resultado").toggleClass("nodisplay");
				$("#resultado-info").html(data.responseText);
			});
		});
	});
</script>