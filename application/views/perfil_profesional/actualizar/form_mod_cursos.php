        <div class="barra-despliegue-datos" id="barra-cursos">
            <label data-icon="&#xe006;"> Cursos asociados:</label>
            <span data-icon="V"> click para visualizar/ocultar documentos</span>
        </div>      
        
        <div class="cont-datos-ver" id="ver-cursos" style="width:80%; margin:0 auto;">
            <table class="table table-bordered">
                <thead>
                    <tr class="">
                        <th>No.</th>
                        <th>curso</th>
                        <th>Fecha de expendicion</th>
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
                            <td> <a href="<?= site_url('perfil/delete_curse/'.$cu->persona_identificacion."/".$cu->idcurso)?>" class="btn btn-danger"> X </a> </td>
                        </tr>
                        <?php
                    }               
                    ?>
                </tbody>
            </table>

            <hr>    
            <div class="agregar-section">
                <button type="button" id="add-cursos" class="btn btn-primary" >
                    &nbsp;Agregar un nuevo <span class="">curso</span> <span data-icon="<"></span>                    
                </button>
                <button type="button" id="del-cursos" class="btn btn-warning">
                        Remover selecion de <span class="">curso</span> (-)
                </button>

                <form id="" method="post">
                    <div id="agregar-cursos" class="nodisplay">
                        

                        <button type="button" class="btn btn-success" id="add-curso" data-icon="%"> Actualizar cargos</button>             
                    </div>
                </form>
            </div>
        </div>