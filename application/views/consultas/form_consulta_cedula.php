    
    <div class="block clear">
    <script>
        $(document).ready(function(){
            $("#quitarced").on("click",function(){
                $(this).parent("div").remove();
            });
        });
    </script>
        <div class="form-group col-md-6">
            <div class="input-group">
                <div class="input-group-addon">Ingrese el No. de <code>identificacion</code> a buscar <span class="bg-danger">(Debe ser excacto)</span>: .</div>
                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Aqui ingrese su identificacion">
            </div>
        </div>
        <button type="button" id="quitarced" class="btn btn-danger"> Retirar busqueda cedula(x)</button>
    </div>
