<!DOCTYPE html >
<html lang="es">
	<?php $this->load->view('inicio/head',array()); ?>
	<body>

        <script type="text/javascript">
            var tp = false;
        $(document).ready(function(){
            $("#ver-pass").on("click",function(){
                if(!tp){
                    $("#password").attr({type:"text"});
                    tp = true;
                }else{
                    $("#password").attr({type:"password"});
                    tp = false;
                }
            });
            
            $(".detalle").on("click",function(){
                alert("campo obligatorio");
            })
            ;
            $(document).on('click', function(e) {
              if (e.button == 2) {
                  e.preventDefault();
                  alert("Algunas funcionalidades has sido deshabilitadas en este punto por seguridad.");
                  return;
              }
            });
        });
        </script>

		<?php $this->load->view("inicio/header2",array()); ?>
		<hr class="hr-termo">
		<div class="bg-gray">
            <section class="cuerpo-ini">
                <style>
                    #inisession{
                        width:80%;
                        margin:0 auto;
                    }
                    form h3{
                        font-family: 'Michroma', sans-serif;
                    }
                    
                </style>
                <?php
                if(isset($error) && $error){
                    ?>
                    <h4 class="bg-danger">Los datos ingresados no son correctos.</h4>
                    <?php
                }
                ?>
                
                <form action="<?= site_url("sesion/validar_datos") ?>" method="POST">
                    <fieldset>
                        <legend><h3>Iniciar sesión</h3></legend>
                    </fieldset>    
                    <div id="inisession">
                        
                        <div class="form-group">
                            <label class="sr-only" for="user">Usuario:</label>
                            <div class="input-group">
                              <div class="input-group-addon" data-icon="@"> Nombre de Usuario:</div>
                              <input type="text" class="form-control" id="user" name="user" 
                                     placeholder="Ingrese aqui el nombre de usuario" autofocus required>
                              <div class="input-group-addon detalle" data-icon='"'> </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="sr-only" for="password">Password:</label>
                            <div class="input-group">
                              <div class="input-group-addon" data-icon="&#xe005;"> Su Contraseña:</div>
                              <input type="password" class="form-control" id="password" name="password" 
                                     placeholder="Ingrese aqui su contraseña" required>
                              <div class="input-group-addon detalle" style="cursor:pointer" data-icon='"' > </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success" data-icon="&#xe007;"> Iniciar sesión</button>
                        <br><br>
                        
                        <p>
                            <a href="<?= site_url('welcome/recover') ?>"> ¡He olvidado mis datos de acceso!</a>
                        </p>
                    
                    </div>
                </form>
                
                <!-- gestiones -->
                <hr style="clear:left"/>

                <br>
            </section>
        </div>
        
        <hr class="hr-gray">
		<?php $this->load->view('inicio/footer'); ?>      

	</body>
</html>