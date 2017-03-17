    
    <a href="<?= site_url('consulta') ?>" class="btn btn-info"> << Volver a consultas</a>
    
    <link href="<?php echo base_url("assets/estilo-consultas.css") ?>" rel="stylesheet" type="text/css" >
    <script>
        function getuser(iduser){
            $.ajax({
                url: "<?= site_url('sesion/get_user') ?>/"+iduser,
                success:  function(msj){
                    alert("usuario: "+msj);
                },
                error:function(ms1){
                    alert(JSON.stringify(ms1))
                }
            });
        }

        $(document).ready(function(){
            $("#ver-cargos").hide();
            $("#ver-documentos").hide();
            $("#ver-cursos").hide();
            
            $("#barra-cargos").on("click",function(){
                $("#ver-cargos").toggle("fast");  
            });

            $("#barra-documentos").on("click",function(){
                $("#ver-documentos").toggle("fast");
            });

            $("#barra-cursos").on("click",function(){
                $("#ver-cursos").toggle("fast");
            });
            
            //-------------------------------------------------------------------
            //agregar formulario de agregar nuevo cargo
            //-------------------------------------------------------------------
            $("#add-cargos").on("click",function(){
                $("#agregar-cargo").show();
                $.ajax({
                    url: "<?php echo site_url('perfil/form_add_new_cargo/'.$idper); ?>/"+1,
                    success: function(data){
                        $("#cargos").append(data);
                    },
                    error: function(){
                        alert("error");
                    }
                });
            });
            $("#del-cargos").on("click",function(){
                $("#agregar-cargo").hide();
                var cargo = $("div#cargos > div").get(0)
                $(cargo).remove();
            });
            $("#btn-ver").on("click",function(){
                $("#ver-cargos").toggle("slow");  
                $("#ver-documentos").toggle("slow");
            });
            
            //agregar el cargo en la BD
            $("#add-cargo").on("click",function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('perfil/agregar_cargo_persona/'); ?>",
                    data: { id: "<?php echo $idper ?>", codcargo1: $("#codcargo1").val(), resu: '<?= $this->session->userdata("idusuario") ?>', base: '<?= $this->session->userdata("base_idbase"); ?>' },
                    beforeSend:function(){
                    },
                    error:function(xhr, httpStatus, error){alert("error: "+error+" - stratus de peticion: "+httpStatus)},
                    success:function(data){
                        location.reload();
                    },
                    statusCode: {
                        400: function(){alert("Mala petición de servicio.");},
                        404: function(){alert("Pagina no encontrada");},
                        500: function(){alert("Error interno del servidor");}
                    }
                });
            });
            
            //-------------------------------------------------------------------
            
            //-------------------------------------------------------------------
            //agregar formulario de anexar documento.
            //-------------------------------------------------------------------
            $("#add-doc").on("click",function(){
                $("#agregar-docs").load("<?php echo site_url('perfil/form_add_doc_type/'.$idper.'') ?>");
                $("#agregar-docs").show();
            });
            $("#del-doc").on("click", function(){
                $("#agregar-docs > div").remove()
            });

            //---------------------------------------------------------------------------
            //agregar curso al perfil de la persona
            //---------------------------------------------------------------------------
            $("#add-cursos").on("click",function(){
                $("#agregar-cursos").load("<?php echo site_url('perfil/form_add_curso/'.$idper.'') ?>");
                $("#agregar-cursos").show();
            });
            $("#del-cursos").on("click", function(){
                $("#agregar-cursos > *").remove()
            });            

            $(".observer").on("click",function(){
                var id = $(this).attr("id");
                                
                $.get( "<?= site_url('aprobacion/obs'); ?>/"+id, function( data ) {
                    $("#observacion #coment").text(data);
                }).error(function(x){alert(JSON.stringify(x))});
                $("#observacion").show();
            });

            $("#cerrar-obs").on("click", function(){
                $("#observacion").hide();
            }); 
            
        });
    </script>
    <div style="background:#fff"> 
        
        <!-- ============================ DATOS DE LA APLIACION ========================= -->

        <hr>
        <?php $this->load->view("perfil_profesional/actualizar/form_mod_cursos") ?>
        <hr>

        <?php $this->load->view("perfil_profesional/actualizar/form_mod_documentos") ?>

        <!-- ------------------------------------------------------------ -->    
        
        <?php $this->load->view("perfil_profesional/actualizar/form_mod_cargos") ?>
        
        <br>
        
	</div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".btn-del-cargo").on("click",function(){
                var link = $(this).data("link");
                window.location.href = link; 
            })
        });
    </script>