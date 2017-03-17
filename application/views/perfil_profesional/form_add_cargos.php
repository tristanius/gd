    <script type="text/javascript">
      $(document).ready(function(){
          var items = 0;
          $("#ncargo").on("click",function(e){
            e.preventDefault();
            items = items+1;
            $("#cargo").load("<?php echo site_url('perfil/form_add_new_cargo') ?>/"+items);
          });
      });
    </script>

    <form role="form" class="form-inline" enctype="multipart/form-data" 
          action="<?php echo site_url("perfil/")?>" method="POST">
        <legend>
            <h3>Paso 3: Asignacion de posibles cargo a desempeñar.</h3>
            <h4>"Gestion: Hojas de vida y cargos de personal"</h4>
        </legend>
        
        <p>
            Agrega cargos a la persona registrada con identificacion: <?php echo $idper ?>.
            El no llenar estos campos dejaria un perfil incompleto, pero no es obligatorio.
        </p>

        <br>
        
        <button type="button" id="ncargo" class="btn btn-success"> Add. Cargo  aprobado</button>
                
        <div id="cargo">
        
        </div>
    </form>