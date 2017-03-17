	<div ng-app="admin" ng-controller="privilegio">
		<form ng-submit="send()" class="form bg-info" style="overflow:hidden;" method="post" accept-charset="utf-8">
			<legend><h3>Gestión de roles de usuarios</h3></legend>
			
			<div class="form-group col-md-3">
				<label for="name">Nombre:</label>
				<input id="name:" name="name:" ng-model="name" type="text">
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
					<th>NOMBRE ROL</th>
					<th>ESTADO</th>
					<th>Ver privilegios</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat=" it in roles ">
					<td> {{ it.idrol }} </td>
					<td> {{ it.nombre_rol }} </td>
					<td> {{ it.activo }} </td>
					<td> <a href="<?= site_url('administrator/rol_privilegios') ?>/{{ it.idrol }}" class="btn btn-default" style="padding:3px">Ver</a> </td>
				</tr>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		var app = angular.module("admin", []);
		app.controller("privilegio",function($scope, $http){
			$scope.roles = <?= json_encode($roles->result()) ?>;

			$scope.send = function(){
				var post = {
						'nombre_rol':$scope.name,
						'estado':true
					};

				$http.post("<?= site_url('administrator/add_rol') ?>", post )
				.success(function(data){
					$scope.roles.push(data);
				})
				.error(function(data){
					alert("Error: "+JSON.stringify(data));
				});
			}
		});
	</script>