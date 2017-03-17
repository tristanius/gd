<div style="width:97%; margin:0 auto;">
            <label>Cargos y Documentos propios de esta persona:</label>
        </div>
                
        <!-- --------------------------------------------------------------- -->

        
        <div class="barra-despliegue-datos" id="barra-documentos">
        	<label data-icon="&#xe006;"> Documentos asociados:</label>
            <span data-icon="V"> click para visualizar/ocultar documentos</span>
        </div>      
        
        <div class="cont-datos-ver" id="ver-documentos" style="width:80%; margin:0 auto;">
            <table class="table table-bordered">
                <thead>
                    <tr class="">
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
                    <tr style="background:#FFF;">
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
                            <?php
                            $priv = $this->session->userdata("privilegios");
                            if (isset($priv->{25})) {
                            ?>
                            <a href="<?= site_url('perfil/confirDelDocPerfil/'.$doc->iddocumento."/".$idper) ?>" class="btn btn-danger"> (-) Del Doc.</a>
                            <?php
                            }
                            ?>
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

            <hr>    
            <div class="agregar-section">
                    <button type="button" id="add-doc" class="btn btn-primary">
                        &nbsp;Agregar un nuevo <span class="">DOCUMENTO </span> <span data-icon="7"></span>
                </button>
                <button type="button" id="del-doc" class="btn btn-warning">
                        Remover campo de nuevo <span class="">DOCUMENTO </span> (-)
                </button>
                    
                <div id="agregar-docs" class="nodisplay">
                    <p class="bg-warning">Recuerde que el documento debe estas escaneado en 300ppi</p>
                    <div id="docs" class="">

                    </div> 
                    <!-- <button type="button" class="btn btn-success" id="add-doc" data-icon="%">Agregar Documento</button>-->
                </div>
                <br>
            </div>
        </div>