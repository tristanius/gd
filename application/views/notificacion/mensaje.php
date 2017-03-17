<div class="">
		<legend> <h2 class="bg-warning">Sistema de mensajes y memos: </h2> </legend>
		<table class="table" style="width: 85%; margin: 0 auto">
			<thead>
				<tr>
					<th>Titulo</th>
					<th>Fecha de envio</th>
					<th>Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($mensajes->result() as $msj) {
				?>
				<tr>
					<td><?= $msj->nombre_memo ?></td>
					<td><?= $msj->fecha_envio ?></td>
					<td><a href="<?= base_url($msj->ruta) ?>" class="btn btn-info" data-icon="7"> Enlace al archivo</a></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
</div>
<br>