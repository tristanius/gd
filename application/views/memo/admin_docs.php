<a href="<?= site_url('memo') ?>" class="btn btn-danger"> << Volver</a>
<legend><h3>Gestión de  documentos de recepción al sistema:</h3></legend>
<table class="table table-bordered">
    <thead>
        <tr class="">
            <th>No.</th>
            <th>Tipo de documento</th>
            <th>Fecha de creacion</th>
            <th>Nombre del documento</th>
            <th>ver</th>
            <th>Enviar</th>
            <th>Borrar</th>
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
            <td><?php echo $doc->tipo ?></td>
            <td><?php echo $doc->fecha_subida ?></td>
            <td><?php echo $doc->nombre_documento ?></td>
            <td>
                <a target="_blank" class="btn btn-ver" 
                   href="<?php echo base_url("uploads/".$doc->persona_identificacion."/".$doc->nombre_documento); ?>" data-icon="&#xe004;"> 
                    Ver documento 
                </a>
            </td>
            <td>
                <a class="btn btn-info" 
                   href="<?php echo site_url('memo/envia/'.$doc->iddocumento) ?>" data-icon=")"> 
                    Enviar a un usuario 
                </a>
            </td>
            <td>
                <a class="btn btn-danger" 
                   href="<?php echo site_url('memo/del/'.$doc->iddocumento)?>" > 
                    Eliminar (X)
                </a>
            </td>
        </tr>
        <?php
        }				
        ?>
    </tbody>
</table>