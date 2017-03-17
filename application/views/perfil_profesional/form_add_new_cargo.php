	
    <div class="div-form-ajax" style="margin: 5px;">
    	<!--  ============ plugins =========== -->
	    <!-- chosen -->
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/chosen/chosen.min.css") ?>">
	    <script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js') ?>"></script>
	    <script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.proto.min.js') ?>"></script>
	    <script type="text/javascript">
	        $(document).ready(function(){
	            $(".chosen-select").chosen({disable_search_threshold: 5});
	        });
	    </script>
    	<label>Seleccione el cargo aprobado que puede desempeñar: </label>
	    <select class="chosen-select" id="codcargo<?php echo $item ?>" name="codcargo<?php echo $item ?>">
	    <?php 
	    foreach ($cargos->result() as $cargo) {
	    	?>
	    	<option value="<?php echo $cargo->codigo ?>"> <?= $cargo->nombre ?> </option>
	    	<?php
	    }
	    ?>
	    </select>
    </div>