<div class="block clear" >
    
    <!--  ============ plugins =========== -->
    <!-- chosen -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/chosen/chosen.min.css") ?>">
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/chosen/chosen.proto.min.js') ?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".chosen-select").chosen();
            $("#quitarc<?php echo $item ?>").on("click", function(e){
                var c = $("#form-cargo >div").length;
                /*if(e.target == this)
                    alert("ok");*/
                $("#ncargos").val(c-1);
                $("#form-cargo > div").get(c-1).remove();
            });
        });
    </script>
    <label><?php echo $item ?>. Seleccione el cargo a buscar: </label>
    <select class="chosen-select col-md-4" name="cargo<?php echo $item; ?>">
        <?php
        foreach($cargos->result() as $cargo){
        ?>
        <option value="<?php echo $cargo->codigo ?>"> <?php echo $cargo->nombre ?> </option>
        <?php
        }
        ?>
    </select>
    <button type="button" id="quitarc<?php echo $item ?>" class="btn btn-danger"> Retirar campos de cargos (x)</button>
</div>