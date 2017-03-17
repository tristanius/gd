    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/estilo-consultas.css') ?>" />
    <a href="<?= site_url('consulta') ?>" class="btn btn-default">Volver a consultas</a>

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


    <div>
        <h3>Vista de resultados de la consulta.</h3>
        <h4>
            Esta vista le permitira visualizar quienes estan dentro de los parametros
            de busqueda realizada.
        </h4>
        <hr class="hr-termo">
        
        <table class="table" id="myTable">
            <thead class="termo-thead1">
                <tr>
                    <th>No.</th>
                    <th>Identificacion</th>
                    <th>Nombre completo</th>
                    <th>Cargo</th>
                    <th style="min-width: 89px">Creado desde</th>
                    <th style="min-width: 89px">M. Obra</th>
                    <th style="min-width: 130px">Estado</th>
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
                    <td><?php echo $no ?></td>
                    <td><b><?php echo $pg->identificacion ?></b></td>
                    <td><?php echo $pg->primer_nombre." ".$pg->segundo_nombre." ".$pg->primer_apellido." ".$pg->segundo_apellido ?></td>
                    <td><?php echo $pg->nombre ?></td>
                    <td><?= isset($pg->basecreacion)?$pg->basecreacion:""; ?></td>
                    <td><?= $pg->base_idbase ?></td>
                    <td><?php echo existe_aprobacion($pg->idpersona_has_cargo)?estado_aprobacion($pg->idpersona_has_cargo):"En espera"; ?></td>
                    <td >
                        <a class="btn btn-ver" href="<?php echo site_url("perfil/ver/".$pg->identificacion) ?>" data-icon="&#xe004;">
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