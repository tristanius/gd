	<div ng-app="admin" ng-controller="privilegio_rol">
		<form ng-submit="send()" class="form bg-info" style="overflow:hidden;" method="post" accept-charset="utf-8">
			<legend><h3>Gestión de privilegios de usuarios</h3></legend>
			
			<div class="form-group col-md-3">
				<label for="name">ROL:</label> {{ rol.nombre_rol }}
			</div>
			<div class="form-group col-md-3">
				<label for="privi">privilegio:</label>
				<select name="privi" ng-model="privi">
					<option ng-repeat="g in privilegios" value="{{ g.idprivilegio }}">{{ g.nombre_privilegio }}</option>
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
					<th>Nombre</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat=" it in privilegios_rol ">
					<td> {{ it.idprivilegio_has_rol }} </td>
					<td> {{ it.nombre_privilegio }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		var app = angular.module("admin", []);
		app.controller("privilegio_rol",function($scope, $http){
			$scope.rol = <?= json_encode($rol) ?>;
			$scope.privilegios_rol = <?= json_encode($privilegios_rol->result()) ?>;

			$scope.privilegios = <?= json_encode($privilegios->result()) ?>;
			$scope.privi = "1";

			$scope.getNombrePr = function(id){
				var nombre = "test";
				angular.forEach($scope.privilegios, function(value, key){
					if(value.idprivilegio == id){
						nom =  value.nombre_privilegio;
					}
				});
				return nom;
			}

			$scope.send = function(){
				var nom = $scope.getNombrePr($scope.privi);
				var post = {
						'rol_idrol': $scope.rol.idrol ,
						'privilegio_idprivilegio': $scope.privi,
						'nombre_privilegio': nom
					};
					
				$http.post("<?= site_url('administrator/add_privilegio_rol') ?>", post ).success(function(data){
					$scope.privilegios_rol.push(data);
				})
				.error(function(data){
					alert("Error: "+JSON.stringify(data));
				});
			}
		});
	</script>