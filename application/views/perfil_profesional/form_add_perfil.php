    <link href='http://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
    <style>
        .identificador{
            font-family: 'Michroma', sans-serif;
        }
    </style>

    <script>
        function nuevo(){                            
            $('#ver-div-add-doc').show();
            $('#div-add-doc').hide();
        }
        var valid = false;
        $(document).ready(function(){
            $("#btn-cont").hide();
            $("#btn-cont2").hide();
            var url = "POST";
            var item = 0;
            valid = false;


            $("#add-cargos").on("click",function(){
                item = item + 1;
                $.ajax({
                    url: "<?php echo site_url('perfil/form_add_new_cargo/'.$idper); ?>/"+item,
                    success: function(data){
                        $("#cargos").append(data);
                        $("#no_cargos").val(item);
                        $("#form-cargo").attr("method",url);
                    }
                })
            });

            $("#del-cargos").on("click",function(){
                item = item - 1;
                var cargo = $("div#cargos > div").get(item)
                $(cargo).remove();
                $("#no_cargos").val(item);
            })
            $("#form-cargo").on("submit",function(e){
                if(valid == false){
                    e.preventDefault();
                    alert("proceso no terminado!");
                }                
            });
            
            $("#submit-btn").on("click",function(){
                if (valid){
                    $("#form-cargo").submit();
                }            
            });

            $('#ver-div-add-doc').on('click',function(){
                $('#div-add-doc').show();
                $('#div-add-doc').load('<?php echo site_url('perfil/form_add_doc_type/'.$idper."/".TRUE)?>');
                $('#ver-div-add-doc').hide();
            });
        });
    </script>

    <a href="<?= site_url() ?>" class="btn btn-primary"><< Volver principal</a>

    <div id="a"></div>    
    <form id="form-cargo" role="form" class="form" method="POST" enctype="multipart/form-data" 
          action="<?php echo site_url("perfil/add_perfil")?>" method="POST">
        <legend>
            <h4>Paso 2: Registro de datos y archivos del personal.</h4>
            <h5 style="text-align: center">"Gestion: Hojas de vida y cargos de personal"</h5>
        </legend>
        
        <h4 class="bg-info"  style="text-align:center">
            No. de Identificación: <span class="identificador"><?php echo $idper ?></span>
        </h4>
        <input type="hidden" name="idper" value="<?php echo $idper ?>" />
        
        <div class="form-group mdle" >
            <label for="enom1" data-icon="R"> Primer <span class="termo identificador"><B>Nombre</B></span>: * </label>
            <input type="text" class="form-control mdle" name="nom1" id="nom1" 
                   placeholder="Ingrese primer apellido" required autofocus>
        </div>
        <div class="form-group mdle">
            <label for="nom2" data-icon="R"> Segundo <span class="termo identificador">Nombre</span>:</label>
            <input type="text" class="form-control mdle" name="nom2" id="nom2" 
                   placeholder="Ingrese el segundo nombre" >
        </div>
        
        <hr>
        
        <div class="form-group mdle">
            <label for="ape1" data-icon="/"> Primer <span class="termo identificador">Apellido</span>:* </label>
            <input type="text" class="form-control mdle" name="ape1" id="ape1" 
                   placeholder="ingrese primer apellido" required>
        </div>
        <div class="form-group mdle">
            <label for="ape2" data-icon="/"> Segundo <span class="termo identificador">Apellido</span>: </label>
            <input type="text" class="form-control mdle" name="ape2" id="ape2" 
                   placeholder="ingrese segundo apellido" >
        </div>

        <hr  style="clear:left; overflow:hidden">
        
        <div class="form-group  col-md-4">
            <label>Escolaridad:</label>
            <select class="form-control" name="escolaridad">
                <option value="Empirico"> Empirico </option>
                <option value="Bachiller"> Bachiller </option>
                <option value="Tecnica/Tecnologia"> Tecnica/Tecnologia </option>
                <option value="Profesional"> Profesional </option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>
                Titulo (Solo tecnico o profesional):
            </label>
            <input class="form-control" type="text" name="titulo" placeholder="ingrese aqui el titulo obtenido">
        </div>

        <div class="form-group  col-md-5">
            <label for="mobra_local">Mano de obra local:
                <input type="checkbox" name="mobra_local" class="form-control" style="display:inline; margin:0;padding:0; width: 3ex; height: 3ex">
            </label>            
        </div>

        <!--<div class="form-group col-md-4">
            <label>
                Lugar de nacimiento:
            </label>
            <input class="form-control" type="text" name="lugar_nacimiento" placeholder="ingrese aqui el titulo obtenido">
        </div>-->
        
        <div class="clear"></div>

        


        <div class="clear"></div>
        <hr>
        
        <!-- 
        <input type="file" value="archivo" name="file" />
        <input type="submit" value="enviar" />

        <label>Seleccione el tipo de documebnto que desea subir:</label>
        <select name="tipo" id="tipo-doc">
            <option value="hoja de vida">Hoja de vida</option>
            <option value="ceritficado medico">Certificado Medico</option>
            <option value="certificado de estudios">Certificado de estudios</option>
            <option value="Foto">Foto</option>
            <option value="otro">Otro</option>
        </select>
        -->
        
        
        <button type="button" id="ver-div-add-doc" class="btn btn-primary" data-icon="&"> Agregar Documento</button>
        
        
        <div id="div-add-doc">

        </div>
        
        <br>
        <ul id="text-archivos"></ul>
        
        <div class="clear"></div>        
        <hr>
        
        <div id="btn-cont" style="margin: 5px;">
            <h3 class="bg-success"> Archivo subido al servidor.</h3>
        </div>

        <h5>Agrega cargos para completar el perfil:</h5>
        <button type="button" id="add-cargos" class="btn btn-info">Agregar un nuevo cargo (+)</button>
        <button type="button" id="del-cargos" class="btn btn-danger">Remover item de cargo (-)</button>
        
        <input type="hidden" id="no_cargos" name="no_cargos" value="0">
        
        <div id="cargos">

        </div>

        <hr>
        <div id="btn-cont2">
            <button type="button" id="submit-btn" class="btn btn-success"><strong> GUARDAR</strong> >></button>
        </div>
    </form>