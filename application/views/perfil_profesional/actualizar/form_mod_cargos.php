        <?php 

        $priv = $this->session->userdata("privilegios");
        if(isset($priv->{32}) || isset($priv->{21})){

        ?>


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

        <div class="cont-datos-ver" id="ver-cargos" style="width:80%; margin:0 auto;overflow:visible">
            <table class="table table-bordered">
                <thead>
                    <tr class="">
                        <?php if(isset($priv->{33})){
                        ?>
                        <th><small>Eliminar</small></th>
                        <?php
                        } ?>          
                        <th>No.</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>funcion</th>
                        <th>Fecha peticion</th>
                        <th>Por:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cargos->result() as $carg) {
                    ?>
                    <tr style="background:#FFF;">
                        <?php if(isset($priv->{33})){
                        ?>
                        <td>
                            <button data-link="<?= site_url('perfil/form_del_cargo/'.$carg->idpersona_has_cargo."/".$per->identificacion) ?>" class="btn-del-cargo btn btn-danger">
                                <small>(X) Cargo</small>
                            </button>
                        </td>
                        <?php
                        } ?>
                        <td><?php echo $carg->codigo ?></td>
                        <td><?php echo $carg->nombre ?></td>
                        <td><?php echo existe_aprobacion($carg->idpersona_has_cargo)?estado_aprobacion($carg->idpersona_has_cargo):"Pendiente de respuesta"; ?></td>
                        <td> 
                            <?php 
                            $status = existe_aprobacion($carg->idpersona_has_cargo);
                            $apb = get_aprobacion($carg->idpersona_has_cargo);
                            
                            if($status){
                            ?>
                                <button type="button" class="observer btn btn-ver" data-icon="&#xe004;" id="<?= $apb->idaprobacion ?>"> Obser.</button>
                                <a href="<?= $apb->documento!='#'?base_url('uploads/persona/'.$per->identificacion."/".$apb->documento):"#ver-cargos"; ?>" class="btn btn-info" data-icon="~"> Doc.</a>
                                <!-- <a href="<?= site_url('aprobacion/form_editar/'.$apb->idaprobacion)?>" class="btn btn-warning">Edit.</a>-->
                                <?php
                                if(isset($priv->{33})){
                                    ?>
                                    <a href="<?= site_url('aprobacion/rm/'.$apb->idaprobacion)."/".$per->identificacion ?>" class="btn btn-danger"><small>x</small></a>
                                    <?php
                                }
                            }else if(isset($priv->{32})){
                                ?>  
                                <a href="<?= site_url('aprobacion/aprobar/'.$idper."/".$carg->codigo."/".$carg->idpersona_has_cargo) ?>" class="btn btn-primary" style="background:#107296">Aprobar <span data-icon="k"></span> </a> 
                                <?php
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
            <hr>        
            <div class="agregar-section">
                <button type="button" id="add-cargos" class="btn btn-primary" >
                    &nbsp;Agregar un nuevo <span class="">CARGO</span> <span data-icon="<"></span>                    
                </button>
                    <button type="button" id="del-cargos" class="btn btn-warning">
                        Remover selecion de <span class="">CARGO</span> (-)
                </button>
                <div id="cargos" class="">

                </div>
                <form id="" method="post">
                    <div id="agregar-cargo" class="nodisplay">
                        <button type="button" class="btn btn-success" id="add-cargo" data-icon="%"> Actualizar cargos</button>             
                    </div>
                </form>
            </div>             
        </div>

        <?php 
        }?>