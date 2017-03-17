
    <script type="text/javascript">
      $(document).ready(function(){

      });
    </script>
    <button onclick="history.back()" class="btn btn-primary"><< Volver</button>

    <form role="form" class="form-inline" enctype="multipart/form-data" 
          action="<?php echo site_url("perfil/comfir_valid_id")?>" method="POST">
        <legend>
            <h3>Paso 1: Validacion para registro de perfil laboral.</h3>
            <h4>"Gestion: Hojas de vida y cargos de personal"</h4>
        </legend>
        <?php
        if(isset($err) && $err){
          ?>
          <h5 class="bg-danger">Los IDs ingresados son diferentes en paso 1 y 1.1</h5>
          <?php
        }?>
        <p>
          Ingrese el documento de identidad que desea diligenciar, para saber si no esta esta registrado o si ya ha sido diligenciado, 
          para proceder al siguiente paso. 
        </p>

        <br>
        
        <div class="form-group col-md-8">
            <label class="sr-only" for="cc">C.C. - ID</label>
            <div class="input-group">
              <div class="input-group-addon" data-icon="&#xe005;" > Identificacion (C.C.)</div>
              <input type="text" class="form-control" name="cc" id="cc" 
                     placeholder="Ingrese la identificación EJ: 37222000" autofocus>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Validar y continuar >></button>
                
    </form>