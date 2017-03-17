    
    <div>
        <script type="text/javascript">
        </script>
        
        <form action="<?php echo site_url('perfil/modificar_datos_persona') ?>" method="post">
            <input type="hidden" name="idper" id="idper" value="<?php echo $idper ?>"/> 
            <div class="paginador">
                <div class="form-group  col-md-4">
                    <label class="sr-only" for="nom1"> Primer nombre</label>
                    <div class="input-group">
                        <div class="input-group-addon"> Primer <span class="termo identificador"><b>Nombre</b>:</span> </div>
                        <input type="text" class="form-control" id="nom1" name="nom1" placeholder="ingrese primer nombre actualizar"
                               value="<?php echo $per->primer_nombre ?>">
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label class="sr-only" for="nom2"> Segundo nombre</label>
                    <div class="input-group ">
                        <div class="input-group-addon"> Segundo <span class="termo identificador"><b>Nombre</b>:</span> </div>
                        <input type="text" class="form-control" id="nom2" name="nom2" placeholder="ingrese segundo nombre" 
                               value="<?php echo $per->segundo_nombre; ?>">
                    </div>
                </div>

            </div>
            <br>

            <div class="paginador">
                <div class="form-group  col-md-4">
                    <label class="sr-only" for="ape1">Primer Apellido</label>
                    <div class="input-group">
                        <div class="input-group-addon">Primer <span class="termo identificador"><b>Apellido</b>:</span> </div>
                        <input type="text" class="form-control" id="ape1" name="ape1" placeholder="ingrese primer apellido"
                               value="<?php echo $per->primer_apellido ?>">
                    </div>
                </div>

                <div class="form-group  col-md-4">
                    <label class="sr-only" for="ape2">Segundo Apellido</label>
                    <div class="input-group">
                        <div class="input-group-addon">Segundo <span class="termo identificador"><b>Apellido</b>:</span> </div>
                        <input type="text" class="form-control" id="ape2" name="ape2" placeholder="ingrese segundo apellido"
                               value="<?php echo $per->segundo_apellido ?>">
                    </div>  
                </div>
            </div>

            <br>

            <table class="table">
                <thead>
                    <tr>
                        <th>Escolaridad</th>
                        <th>Titulo</th>
                        <th>Mano de obra local</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                        <select class="form-control" name="escolaridad">
                            <?php 
                            $arr = array("Empirico","Bachiller","Tecnica/Tecnologia","Profesional");
                            foreach ($arr as $key => $value) {
                                ?>
                                <option value="<?= $value ?>" <?php echo $per->escolaridad==$value?"selected":""; ?> ><?= $value ?></option>
                                <?php
                            }
                            ?>
                        </select> 
                        </td>
                        <td><input type="text" class="form-control"  name="titulo" value="<?= $per->titulo ?>"> </td>

                        <td><input type="checkbox" name="mobra_local" <?= $per->mobra_local?"checked":""; ?>></td>
                    </tr>
                </tbody>
            </table>


            <br>
            <div><button type="submit" class="btn btn-success" id="actualizar-info">Actualizar informacion</button></div>        
        </form>
    </div>

    <br>