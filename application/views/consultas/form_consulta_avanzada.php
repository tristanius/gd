<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/estilo-consultas.css') ?>" />

<script type="text/javascript">
    $(document).ready(function(){
        var valid = false;
        $("#ncargos").val(0);
        $("#consulta").on("submit",function(e){
            if(!valid)
                e.preventDefault();
        });
        $("#add-cargo").on("click",function(){
            valid = true;
            var c = parseInt($("#ncargos").val());
            if(c>=12)
                return false;
            $("#ncargos").val(c+1);
            $.ajax({
                url: "<?php echo site_url('consulta/form_consulta_cargos') ?>/"+(c+1),
                success: function(data){
                        $("#form-cargo").append(data);
                    }
            });
        });
        $("#add-ced").on("click",function(){
            valid = true;
            $("#form-ced").load("<?php echo site_url('consulta/form_consulta_ced') ?>");
        });
        $("#add-nombre").on("click",function(){
            valid = true;
            $("#form-nombre").load("<?php echo site_url('consulta/form_consulta_nombre') ?>");
        });


    });
</script>


  <a href="<?= site_url("") ?>" class="btn btn-default"> << ir a menú opciones de este modulo</a>

	<form id="consulta" class="form-horizontal" method="post" action="<?php echo site_url('consulta/get_consulta') ?>">
		<fieldset>
			<legend><h3 style="text-align:left">Formulario de consultas:</h3></legend>
		</fieldset>
        <input type="hidden" value="0" id="ncargos" name="ncargos" />

    	<div style="background: #f6f6f6; padding: 1ex; border: 1px solid #444;">
            <button id="add-cargo" class="btn btn-info" type="button">Agregar consulta por Cargo</button>
            <button id="add-ced" class="btn btn-info" type="button">Agregar consulta por Cedula</button>
            <button id="add-nombre" class="btn btn-info" type="button">Agregar consulta por Nombre/Apellido</button>
            <hr>

            <div id="form-ced" >
            </div>

            <div id="form-nombre">
            </div>

            <div id="form-ape">
            </div>

            <div id="form-cargo">
            </div>

            <br>
            <button type="submit" class="btn btn-success" data-icon="," /> Generar consulta >> </button>
        </div>

        <br>
	</form>

    <?php
    $priv = $this->session->userdata("privilegios");
    if ( isset( $priv->{27} ) ) {
    ?>
    <hr>
    <h3 style="text-align:left" > Consulta de listados:</h3>
    <a class="btn btn-primary" href="<?php echo site_url('consulta/vertodos') ?>" data-icon="N"> Ver todos los registros >></a>
    <a class="btn btn-warning" href="<?php echo site_url('aprobacion/gestiona_inconclusos') ?>" data-icon="/"> Ver cargos pendientes o en espera (!)</a>
    <a class="btn btn-danger" href="<?php echo site_url('aprobacion/gestiona_incompletos') ?>" data-icon="/"> Personas con datos incompletos (!)</a>
    <hr>

    <h3  style="text-align:left" >Informes exportables</h3>

    <?php
    }
    if( isset( $priv->{35} ) || isset( $priv->{36} ) ){
    ?>
    <a href="<?= site_url('informe') ?>"class="btn" style="background:#4969A3; color:#FFF; padding:2ex" data-icon="8"> Informes y reportes</a>
    <span class=""><< Nuevo</span>
    <?php
    }
    ?>
    <br>
    <br>
