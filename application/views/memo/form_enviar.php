<div>
	<!--  ============ plugins =========== -->
    <!-- chosen -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/chosen/chosen.min.css") ?>">
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.proto.min.js') ?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".chosen-select").chosen();
        });
    </script>

	<legend><h4>Formulario de envio de un documento a un usuario:</h4></legend>
	<form class="form-horizontal" action="<?= site_url("memo/enviar") ?>" method="post">
		<div class="form-group">
    		<label for="doc" class="col-sm-2 control-label">Nombre del documento:</label>
    		<div class="col-sm-10">
    			<div> <?= $doc->nombre_documento ?> </div>
      			<input type="hidden" class="form-control" id="nom" name="nom" value="<?= $doc->nombre_documento ?>">
      			<input type="hidden" class="form-control" id="doc" name="doc" value="uploads/<?= $doc->persona_identificacion."/".$doc->nombre_documento ?>">
    		</div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Usuarios de este sistema:</label>
            <div class="col-sm-10">
                <select name="user" class="chosen-select">
                	<?php
                    $d1 = $this->load->database("app1",TRUE); 
                    $users = $d1->get("usuario");
                    foreach ($users->result() as $user) {
                        ?>
                        <option value="<?= $user->idusuario ?>"><?= $user->nombres." ".$user->apellidos ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <button class="btn btn-success">Enviar documento</button>
	</form>
</div>