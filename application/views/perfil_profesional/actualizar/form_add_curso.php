	<script>
		$(document).ready(function() {
			$( "#fecha_exp" ).datepicker();
		});
	</script>
	<br>
	<form  class="form-inline" action="<?= site_url('perfil/addCurso/'.$idper) ?>" method="post" accept-charset="utf-8">
		<input type="hidden" name="idper" id="idper" value="<?= $idper ?>">

		<div class="form-group">
		    <label for="nombre_curso">Nombre del curso: </label>

		    <select name="nombre_curso" class="form-control" id="nombre_curso" >
		    	<option value="LICENCIA DE CONDUCCIÓN">LICENCIA DE CONDUCCIÓN</option>
		    	<option value="MANEJO DEFENSIVO">MANEJO DEFENSIVO</option>
		    	<option value="TRABAJO EN ALTURAS">TRABAJO EN ALTURAS</option>
		    	<option value="TRABAJO EN ESPACIO CONFINADO">TRABAJO EN ESPACIO CONFINADO</option>
		    </select>
		</div>

		<div class="form-group">
		    <label for="nombre_curso">Fecha de expedición: </label>
		    <input type="text" class="form-control" id="fecha_exp" name="fecha_exp" placeholder="Fecha del curso" required>
		</div>
            
        <button type="submi" class="btn btn-success" id="add-curso" data-icon="%"> Actualizar cursos</button>
	</form>