	<div ng-app="admin" ng-controller="privilegio">
		<form ng-submit="send()" class="form bg-info" style="overflow:hidden;" method="post" accept-charset="utf-8">
			<legend><h3>Gestión de usuarios</h3></legend>
			
			<div class="form-group col-md-4">
				<label for="cc">Identificacion:</label>
				<input class="form-control" id="cc:" name="cc" ng-model="cc" type="text" required placeholder="ingrese la Cedula">
			</div>

			<div class="form-group col-md-4">
				<label for="nombre">Nombre:</label>
				<input class="form-control" id="nombre:" name="nombre" ng-model="nombre" type="text" required placeholder="1Nombre 2Nombre">
			</div>
			
			<div class="form-group col-md-4">
				<label for="apellido">Apellido:</label>
				<input class="form-control" id="apellido:" name="apellido" ng-model="apellido" type="text" required placeholder="1Apellido 2Apellido">
			</div>			
			
			<div class="form-group col-md-4">
				<label for="correo">Correo:</label>
				<input class="form-control" id="correo:" name="correo" ng-model="correo" type="text" required placeholder="usuario@micorreo.com.co">
			</div>

			<div class="form-group col-md-4">
				<label for="base">Base:</label>
				<input class="form-control" id="base:" name="base" ng-model="base" type="text" required placeholder="Codigo de centro de operaciones">
			</div>


			<div class="form-group col-md-4">
				<div class="bg-primary" style="padding: 1ex">
					<label for="rol">rol:</label>
					<select name="rol" ng-model="rol" class="form-control">
						<option ng-repeat="g in roles" value="{{ g.idrol }}">{{ g.nombre_rol }}</option>
					</select>
				</div>
			</div>
			<div class="form-group col-md-4">
				<button class="btn btn-success"> + Agregar nuevo</button>
			</div>
			

			<br class="clear">
		</form>

		<table class="table table-stripped">
			<thead>
				<tr>
					<th>ID</th>
					<th>NOMBRE</th>
					<th>APELLIDO</th>
					<th>CEDULA</th>
					<th>USUARIO</th>
					<th>CORREO</th>
					<th>ROL</th>
					<th>BASE</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat=" it in usuarios ">
					<td> {{ it.idusuario }} </td>
					<td> {{ it.nombres }}</td>
					<td> {{ it.apellidos }} </td>
					<td> {{ it.persona_identificacion }} </td>
					<td> {{ it.username }} </td>
					<td> {{ it.correo }} </td>
					<td> {{ it.rol_idrol }}</td>
					<td> {{ it.base_idbase }} </td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		var app = angular.module("admin", []);
		app.controller("privilegio",function($scope, $http){
			$scope.usuarios = <?= json_encode($usuarios->result()) ?>;
			$scope.roles = <?= json_encode($roles->result()) ?>;
			$scope.rol = "1";


			$scope.send = function(){
				var post = {
						'username':$scope.cc,
						'persona_identificacion': $scope.cc,
						'nombres':$scope.nombre,
						'apellidos':$scope.apellido,
						'rol_idrol':$scope.rol,
						'correo':$scope.correo,
						'base_idbase':$scope.base
					};
				console.log( JSON.stringify(post) );

				$http.post("<?= site_url('administrator/add_usuario') ?>", post ).success(function(data){
					$scope.usuarios.push(data);
				})
				.error(function(data){
					alert("Error: "+JSON.stringify(data));
				})
				;
			}
		});
	</script>