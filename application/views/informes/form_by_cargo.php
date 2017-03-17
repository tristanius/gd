			<form class="form" method="POST" action="<?= site_url('informe/get/cargo') ?>" style="overflow:hidden">
					<h4 class="texto-normal">Obtiene un informe de uno a uno los cargos por TODAS las persona resgistrados en la aplicación:</h4>
					<div class="form-group">
						<label class="col-xs-2">Ver en la web
							<div class="col-xs-2">
								<input type="checkbox" name="web">
							</div>
						</label>
					</div>

					<div class="col-xs-12">
						<button class="btn btn-success">Generar</button>
					</div>
			</form>