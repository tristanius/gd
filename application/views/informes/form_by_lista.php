			<form id="getpersonal" class="form-horizontal" method="POST" action="<?= site_url("informe/get/lista") ?>" style="overflow:hidden">
				<fieldset>
					<h4 class="texto-normal">Obtiene una lista de personas por cedula pedida:</h4>
					<div class="form-group">
						<label class="col-md-1">Cedula:</label>
						<div class="col-md-3">
							<input class="form-control" id="txt-cedula" name="cedula" type="text">
						</div>
						<button id="btn-add-cc" type="button" class="btn btn-default col-md-1"> + </button>
					</div>

					<textarea name="json" id="json" style="display:none"></textarea>

					<div id="lista-pedido"></div>

					<div class="form-group">
						<label class="col-xs-2">Ver en la web
							<div class="col-xs-2">
								<input type="checkbox" name="web" >
							</div>
						</label>
					</div>

					<div class="clearfix">
						<button type="button" id="send" class="btn btn-success">Generar</button>
					</div>
				</fieldset>
			</form>

			<script type="text/javascript">
				var mydata = [];

				$(document).ready(function(){					
					
					$("#btn-add-cc").on("click",function(){
						var cedula = $("#txt-cedula").val();
						mydata.push(cedula);
						$("#lista-pedido").append("<li>"+cedula+"</li>");
						$("#json").val(JSON.stringify(mydata))
					});

					$("#txt-cedula").keypress(function (e) {
						if (e.which == 13) {
						    return false;    //<---- Add this line
						}
					});

					$("#send").on("click",function(){
						if(mydata.length == 0){
							alert("no has agregado ninguna cedula");
							return;
						}else{
							$("#getpersonal").submit();
						}							
					});

					function send() {
						$.ajax({
							url: '<?= site_url("informe/get/lista") ?>',
							data: mydata,
							datatype: "json",
							method:"POST",
							success: function(data){
								alert( JSON.stringify(data) );
							},
							error: function(xhr, status, msj){
								alert( JSON.stringify(msj) );
							}
						});
					}
				})
			</script>