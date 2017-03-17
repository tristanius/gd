    
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
                <div class="input-group-addon">Ingrese un <code>nombre o apellido</code> que desea buscar:</div>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Aqui ingrese un nombre o apellido">
            </div>
        </div>
        <button type="button" id="quitarced" class="btn btn-danger"> Retirar busqueda de nombre/apellido(x)</button>
    </div>
