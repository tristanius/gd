			<form class="form-horizontal" method="POST" action="<?= site_url('informe/get/estado') ?>"  style="overflow:hidden">
				<fieldset>
					<h4 class="texto-normal">Genera un listado segun el estado:</h4>
					<div class="form-group">
						<label class="col-md-1">Estado:</label>
						<div class="col-md-4">
							<select class="form-control" name="estado">
								<option>En espera</option>
								<option value="aprobado">Aprobado</option>
								<option value="reprobado">No aprobado</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-2">Ver en la web
							<div class="col-xs-2">
								<input type="checkbox" name="web">
							</div>
						</label>
					</div>
					<div class="clear">
						<button class="btn btn-success">Generar</button>
					</div>
				</fieldset>
			</form>
