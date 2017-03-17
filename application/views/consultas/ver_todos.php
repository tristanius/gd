    <a href="<?= site_url('consulta') ?>" class="btn btn-default"><< Volver a consultas</a>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".observer").on("click",function(){
                var id = $(this).attr("id");                
                $.get( "<?= site_url('aprobacion/obs'); ?>/"+id, function( data ) {
                    if(data == ""){
                        data = "<span style='color:gray'>No tiene observación</span>";
                    }
                    $("#observacion #coment").html(data);
                }).error(function(x){alert(JSON.stringify(x))});
                $("#observacion").show();
            });

            $("#cerrar-obs").on("click", function(){
                $("#observacion").hide();
            });
        })
    </script>
    <div id="observacion" style="margin:5ex; position:fixed; z-index:10;">
            <button id="cerrar-obs" class="btn btn-danger">cerrar (x)</button>
            <legend><h3>Observacion:</h3></legend>
            <div id="coment"></div>
    </div>

    <div id="ver-todos-rango">    
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/estilo-consultas.css') ?>" />
        
        <h3>Vista de todos los registros de cargos y personas</h3>
        
        <p style="text-align: center">
            Total de personas registradas en la aplicacion: 
            <?php 
                $this->load->database();
                echo $this->db->get("persona")->num_rows();
            ?>
        </p>

        <!-- DATATABLES -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="//cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#myTable').DataTable({
                    "language":{"url":"//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json"},
                    "lengthMenu": [[30, 50, 85, 100, -1], [30, 50, 80, 100, "Todo"]]  
                });
            })
        </script>

        <table class="table" id="myTable">
            <thead class="termo-thead1">
                <tr>
                    <th>Identificacion</th>
                    <th>Nombre completo</th>
                    <th>Cargo</th>
                    <th style="min-width: 89px">Creado desde</th>
                    <th style="min-width: 89px">M. Obra</th>
                    <th style="min-width: 200px">Estado</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $est = FALSE;
            $ant = "";
            $no = 0;
            foreach($personas_cargo->result() as $pg){
                $no++;
                if($ant === $pg->identificacion){
                    
                }else if($est){
                    $est = FALSE;
                }else{
                    $est = TRUE;
                }
                ?>
                <tr class="<?php echo $est?"warning":""; ?>">
                    <td><b><?php echo $pg->identificacion ?></b></td>
                    <td><?php echo $pg->primer_nombre." ".$pg->segundo_nombre." ".$pg->primer_apellido." ".$pg->segundo_apellido ?></td>
                    <td><?php echo $pg->nombre ?></td>
                    <td><?= $pg->basecreacion ?></td>
                    <td><?= $pg->base_idbase ?></td>

                    <td>
                        <?php 
                        $apb = get_aprobacion($pg->idpersona_has_cargo);
                        $status = existe_aprobacion($pg->idpersona_has_cargo);
                        if($status){
                        ?>
                        <button type="button" class="observer btn btn-ver" data-icon="&#xe004;" id="<?= $apb->idaprobacion ?>">Observ.</button>
                        <a href="<?= $apb->documento!="#"?base_url('uploads/persona/'.$pg->identificacion."/".$apb->documento):"#"; ?>" class="btn btn-info" data-icon="~"> Documento</a>
                        <?php
                        }
                        echo $status?estado_aprobacion($pg->idpersona_has_cargo):"Pendiente de respuesta"; 
                        ?>
                    </td>
                    
                    <td ><a class="btn btn-ver" href="<?php echo site_url("perfil/ver/".$pg->identificacion) ?>" data-icon="&#xe004;">
                            Ver
                        </a>
                    </td>
                </tr>
                <?php
                $ant = $pg->identificacion;
            }
            ?>
            </tbody>
        </table>
    
        
        <hr class="hr-termo2">   
    </div>