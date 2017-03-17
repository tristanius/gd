    <script>
        function ver(){
            alert("prueba de ver.")
        }
        
        $(document).ready(function(){
            
        });
    </script> 

    <style>
        .identificador{
            font-family: 'Michroma', sans-serif;
        }
    </style>
    <a href="<?= site_url('perfil/ver/'.$per->identificacion) ?>" class="btn btn-default"> << ir a perfil </a>
    <a class="btn btn-default" id="btn-ver" data-icon="&#xe004;" href="#ver"> VER DATOS</a>

    <div>
        <h3>Formularios de actualizacion de datos de persona</h3>
        
        <h4>Actualizar Datos basico de la persona:</h4>
        
        <div class="agregar-section">
            <?php 
                $this->load->view("perfil_profesional/actualizar/form_upd_datos",array("per"=>$per)); 
            ?>
        </div>   
        
    </div>
    

    <hr>
<br>

    <div id="ver">
        <?php 
        echo $vista_ver;
        ?>
    </div>