
    <script type="text/javascript">
      $(document).ready(function(){

      });
    </script>
    <button onclick="history.back(-3)" class="btn btn-primary"><< Volver</button>

    <form role="form" class="form-inline" enctype="multipart/form-data" 
          action="<?php echo site_url("perfil/validar_id")?>" method="POST">
        <legend>
            <h3>Paso 1.1: Confirmacion de ID ingresado para registro de perfil laboral.</h3>
            <h4>"Gestion: Hojas de vida y cargos de personal"</h4>
        </legend>
        
        <h4 class="bg-warning">
            Confirme si esta seguro que el o los datos ingresados son los correctos:
        </h4>

        <br>
        
        <div class="form-group col-md-8">
            <label class="sr-only" for="cc">C.C. - ID</label>
            <div class="input-group">
              <div class="input-group-addon" data-icon="&#xe005;" > Identificacion (C.C.)</div>
              <input type="text" class="form-control" name="cc" id="cc" 
                     placeholder="Ingrese la identificación EJ: 37222000" value="<?php echo $idper ?>" autofocus/>
            </div>
        </div>
        <input type="hidden" name="cc2" value="<?php echo $idper ?>">
        <button type="submit" class="btn btn-success">Validar y continuar >></button>
                
    </form>