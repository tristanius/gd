  <?php
    if (!isset($no_opt)) {
      ?>
      <button onclick="history.back()" class="btn btn-default"> < Volver</button>
      <a href="<?= site_url('consulta') ?>" class="btn btn-info"> << Volver a consultas</a>
      <link href="<?php echo base_url("assets/estilo-consultas.css") ?>" rel="stylesheet" type="text/css" >
      <?php
    }
  ?>


    <script>
        function getuser(iduser){
            $.ajax({
                url: "<?= site_url('sesion/get_user') ?>/"+iduser,
                success:  function(msj){
                    alert("usuario: "+msj);
                },
                error:function(ms1){
                    alert(JSON.stringify(ms1))
                }
            });
        }

        $(document).ready(function(){
            $("#ver-cargos").hide();
            $("#ver-documentos").hide();
            $("#ver-cursos").hide();


            $("#barra-cargos").on("click",function(){
                $("#ver-cargos").toggle("fast");
            });
            $("#barra-cursos").on("click",function(){
                $("#ver-cursos").toggle("fast");
            });

            $("#barra-documentos").on("click",function(){
                $("#ver-documentos").toggle("fast");
            });

            $(".observer").on("click",function(){
                var id = $(this).attr("id");
                $.get( "<?= site_url('aprobacion/obs'); ?>/"+id, function( data ) {
                    $("#observacion #coment").text(data);
                }).error(function(x){alert(JSON.stringify(x))});
                $("#observacion").show();
            });

            $("#cerrar-obs").on("click", function(){
                $("#observacion").hide();
            });
        });
    </script>
    <div>
		<fieldset>
			<legend>
				<h4>Vista de datos de perfil profesional</h4>

			</legend>
		</fieldset>

        <label>Datos basicos de la persona:</label>
        <div class="cont-datos-ver">
            <div class="datos-ver" >
                <span class="etiqueta2">Identificacion: </span>
                <span class="data"><?php echo $per->identificacion ?></span>
            </div>
            <div class="datos-ver" id="nombre">
                <span class="etiqueta2">Nombre: </span>
                <span class="data"><?php echo $per->primer_nombre." ".$per->segundo_nombre ?></span>
                <span class="data"><?php echo $per->primer_apellido." ".$per->segundo_apellido ?></span>
            </div>

            <hr>
            <br>
            <br>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Escolaridad</th>
                        <th>Titulo</th>
                        <th>Mano de obra local</th>
                        <th>Base que certifica obra local</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $per->escolaridad ?>
                        </td>
                        <td> <?= $per->titulo ?> </td>
                        <td> <?= $per->mobra_local?"Si":"No"; ?> </td>
                        <td> <?= $per->base_idbase ?> </td>
                    </tr>
                </tbody>
            </table>

            <br>

            <hr>
            <table class="table table-bordered">
                <caption>CURSOS</caption>
                <thead>
                    <tr class="">
                        <th>No.</th>
                        <th>curso</th>
                        <th>Fecha de exp.</th>
                        <th>Vigencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 0;
                    foreach ($cursos->result() as $cu){
                        $no++;
                    ?>
                    <tr style="background:#FFF;">
                        <td><?php echo $no ?></td>
                        <td><?= $cu->nom_curso ?></td>
                        <td><?= $cu->fecha_exp ?></td>
                        <td><?= date_diff( date_create(date("Y-m-d")) , date_create(date("Y-m-d",strtotime($cu->fecha_exp))) )->y >= 1? "<b style='color:red'>".$cu->vigencia."</b>":$cu->vigencia; ?></td>
                    </tr>
                    <?php
                    }               
                    ?>
                </tbody>
            </table>
        </div>
            
        <hr>

        <!-- --------------------------------------------------------------- -->
        <div class="barra-despliegue-datos" id="barra-documentos">
        	<label data-icon="&#xe006;"> Documentos asociados:</label>
            <span data-icon="V"> click para visualizar/ocultar documentos</span>
        </div>
        <div class="cont-datos-ver" id="ver-documentos" style="width:80%; margin:0 auto;">
            <table class="table table-bordered">
                <thead>
                    <tr class="termo-thead2">
                        <th>No.</th>
                        <th style="font-size:9px">FICHA.</th>
                        <th>Tipo de documento</th>
                        <th>Fecha de creacion</th>
                        <th>Nombre del documento</th>
                        <th>ver</th>
                        <th>Por:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($docs->result() as $doc){
                        $no++;
                    ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td style="font-size:9px"><?= $doc->iddocumento ?></td>
                        <td><?php echo tipo($doc->tipo_doc_idtipo_doc) ?></td>
                        <td><?php echo $doc->fecha_subida ?></td>
                        <td><?php echo $doc->nombre_documento ?></td>
                        <td>
                            <a target="_blank" class="btn btn-ver"
                               href="<?php echo base_url("uploads/persona/".$per->identificacion."/".$doc->nombre_documento); ?>" data-icon="&#xe004;">
                                Ver documento
                            </a>
                        </td>
                        <td>
                            <?= $doc->base_creacion ?> -
                            <a onclick="getuser(<?= $doc->usuario_creacion ?>)" class="btn btn-ver">usuario</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- ------------------------------------------------------------ -->
        <div class="spacer"></div>
        <div class="barra-despliegue-datos" id="barra-cargos">
            <label data-icon="&#xe006;"> Cargos aprobados para desempeñar:</label>
            <span data-icon="V"> click para visualizar/ocultar cargos</span>
        </div>

        <div id="observacion" style="">
            <button id="cerrar-obs" class="btn btn-danger">cerrar (x)</button>
            <legend><h3>Observacion:</h3></legend>
            <div id="coment"></div>
        </div>



        <div class="cont-datos-ver" id="ver-cargos" style="width:80%; margin:0 auto;">
            <table class="table table-bordered">
                <thead>
                    <tr class="termo-thead1">
                        <th>No.</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                        <th>Fecha peticion</th>
                        <th>Por:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cargos->result() as $carg) {
                        $status = existe_aprobacion($carg->idpersona_has_cargo);
                        $apb = get_aprobacion($carg->idpersona_has_cargo);
                    ?>
                    <tr>
                        <td><?php echo $carg->codigo ?></td>
                        <td><?php echo $carg->nombre ?></td>
                        <td data-cargoper="<?= $carg->idpersona_has_cargo ?>">
                        <?php
                        $status = existe_aprobacion($carg->idpersona_has_cargo);
                        echo $status?estado_aprobacion($carg->idpersona_has_cargo):"Pendiente de respuesta";
                        ?>
                        </td>
                        <td>
                        <?php
                        if($status){
                        ?>
                        <button type="button" class="observer btn btn-ver" data-icon="&#xe004;" id="<?= $apb->idaprobacion ?>"> Observ.</button>
                        <a href="<?= $apb->documento!='#'?base_url('uploads/persona/'.$per->identificacion."/".$apb->documento):"#ver-cargos"; ?>" class="btn btn-info" data-icon="~"> Documento</a>
                        <?php
                        }
                        else{
                            $priv = $this->session->userdata("privilegios");
                            if(isset($priv->{32})){
                            ?>
                            <a href="<?= site_url('aprobacion/aprobar/'.$per->identificacion."/".$carg->codigo."/".$carg->idpersona_has_cargo) ?>" class="btn btn-primary" style="background:#107296">Aprobar <span data-icon="k"></span></a>
                            <?php
                            }
                        }
                        ?>
                        </td>
                        <td><?= $carg->fecha_cargo ?></td>
                        <td>
                            <?= $carg->base_creacion ?> - <a class="btn btn-ver" onclick="getuser(<?= $carg->usuario_creacion ?>)">usuario</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top:1ex; overflow:hidden">
            <hr>
            <?php 
            $priv = $this->session->userdata("privilegios");
            if (isset($priv->{21})) {
            ?>
            <a id="btn-actualizar" href="<?php  echo site_url("perfil/form_modificar/".$per->identificacion); ?>" style="float:right" class="btn btn-warning" <?= isset($no_opt)?"target='_blank'":""; ?>>
                <span data-icon="v"></span> Actualizar datos
            </a>
            <?php
            }
            ?>
        </div>

	</div>
