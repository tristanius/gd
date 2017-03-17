    <div>
        <script>                        
            //--------- subir
            $(document).ready(function(){
                function opt(){
                    var data = {
                        url:"<?php echo isset($add)?site_url('perfil/upload_doc_type_add/'.$idper):site_url('perfil/upload_doc_type_add/'.$idper);?>",
                        fileName:"file",
                        allowedTypes:"pdf,doc,docx,xlsx,xls,xlm,xml,xlsm",
                        dynamicFormData: function(){
                                var arr = {
                                    tipo: $("#type-doc").val(),
                                    otro: $("#otro").val(),
                                    actu: 1,
                                    resu: '<?= $this->session->userdata("idusuario") ?>',
                                    base: '<?= $this->session->userdata("base_idbase") ?>'
                                }
                                return arr;
                            },
                        onSubmit:function(files){
                        },
                        onSuccess:function(files,data,xhr){
                            alert(JSON.stringify(data));
                            //$("#uploader-div").hide();                                                              
                            <?php
                            if(!isset($add)){
                            ?>

                                window.location.href = "<?php echo site_url('perfil/form_modificar/'.$idper) ?>";

                            <?php
                            }else{
                            ?>
                            nuevo();
                            $("#text-archivos").append("<li>"+JSON.stringify(data)+"</li>");
                            valid = true;
                            if (valid){
                                $("#btn-cont2").show();
                            }

                            <?php
                            }
                            ?>
                        },
                        onError: function(files,status,Msg){
                            alert(JSON.stringify(Msg));
                            alert(JSON.stringify(status));
                            alert(JSON.stringify(data));
                            alert(JSON.stringify(files));
                        }
                    }
                    return data;
                }
                $("#otro-doc").hide();        
                var updFile = $("#uploader").uploadFile(opt());
                
                $("#type-doc").on( "change",function(){
                    if(this.value == "otro" || this.value == "contrato")
                        $("#otro-doc").show();
                    else
                        $("#otro-doc").hide();
                });
            });
        </script>
        
        <div id="uploader-div">
            <p class="bg-warning">Recuerde que el documento debe estas escaneado en 300ppi</p>
            <br>
            <div>    
                <label>Escoja el tipo de documento:</label>
            
                <select name="type-doc" id="type-doc">
                <?php
                $tipos = $this->db->get_where("tipo_doc",array("gestion_idgestion"=>1));
                foreach ($tipos->result() as $tp) {
                    ?>
                    <option value="<?= $tp->idtipo_doc ?>"><?= $tp->nombre_tipo ?></option>
                    <?php
                }
                ?>
                </select>
                <span id="otro-doc">
                    <label>Otro:</label>
                    <input type="text" name="otro" id="otro" value=""/>
                </span>
            </div>
            
            <br>
            
            <label>Subir documento:</label>
            <div id="uploader" clasS="mdle">Click para añadir</div>
        </div> 
    </div>