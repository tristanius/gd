
	<div ng-app="admin" ng-controller="privilegio">
		<form ng-submit="send()" class="form bg-info" style="overflow:hidden;" method="post" accept-charset="utf-8">
			<legend><h3>Gestión de privilegios de usuarios</h3></legend>
			
			<div class="form-group col-md-3">
				<label for="name">Nombre:</label>
				<input id="Name:" name="Name:" ng-model="name" type="text">
			</div>
			<div class="form-group col-md-3">
				<label for="gestion">Gestión:</label>
				<select name="gestion" ng-model="gestion">
					<option ng-repeat="g in gestiones" value="{{ g.idgestion }}">{{ g.nombre_gestion }}</option>
				</select>
			</div>
			<div class="form-group col-md-3">
				<button class="btn btn-primary"> + Agregar nuevo</button>
			</div>
			

			<br class="clear">
		</form>

		<table class="table table-stripped">
			<thead>
				<tr>
					<th>ID</th>
					<th>NOMBRE PRIVILEGIO</th>
					<th>ESTADO</th>
					<th>GESTION</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat=" it in privilegios ">
					<td> {{ it.idprivilegio }} </td>
					<td> {{ it.nombre_privilegio }} </td>
					<td> {{ it.activo }} </td>
					<td> {{ it.gestion_idgestion }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		var app = angular.module("admin", []);
		app.controller("privilegio",function($scope, $http){
			$scope.privilegios = <?= json_encode($privilegios->result()) ?>;
			$scope.gestiones = <?= json_encode($gestiones->result()) ?>;
			$scope.gestion = "1";

			$scope.send = function(){
				var post = {
						'nombre_privilegio':$scope.name,
						'gestion_idgestion':$scope.gestion,
						'ruta':''
					};
				console.log( JSON.stringify(post) );

				$http.post("<?= site_url('administrator/add_privilegio') ?>", post ).success(function(data){
					$scope.privilegios.push(data);
				})
				.error(function(data){
					alert("Error: "+JSON.stringify(data));
				})
				;
			}
		});
	</script>