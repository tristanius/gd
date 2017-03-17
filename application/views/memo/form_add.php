<style type="text/css">
	#text-archivos{
		display: none;
	}
	form{
		width: 70%;
		margin:0 auto; 
	}
	#uploader{
		visibility: hidden;
	}
</style>
<script type="text/javascript">
	 function opt(){
        var data = {
            url:"<?= site_url('memo/upload') ?>",
            fileName:"file",
            allowedTypes:"pdf,doc,docx",
            showProgress: true,
            autoSubmit:false,
            dynamicFormData: function(){
                    return {
                        tipo: $("#type").val(),
                        no: $("#nummemo").val()
                    } 
                },
            onSubmit:function(files){
            	
            },
            onSuccess:function(files,data,xhr){
                alert(JSON.stringify(data));
                $("#text-archivos").append("<li> Agregado: "+JSON.stringify(data)+"</li>");
            },
            onError: function(files,status,Msg){
                alert(JSON.stringify(Msg)+ JSON.stringify(status));
            }
        }
        return data;
    }
    $(document).ready(function(){
    	var uploadObj  = $("#uploader").uploadFile(opt());

    	$("#subir").on("click",function(){
    		if($("#nummemo").val() != ""){
    			uploadObj.startUpload();
    		}else{
    			alert("No ha ingresado ningun numero de memo.")
    		}
    	});
    });

</script>
<div>
	<a href="<?= site_url('memo') ?>" class="btn btn-danger"> << Volver</a>
	<legend><h3>Formulario para agregar un documento de recepción al sistema:</h3></legend>
	<form action="<?= site_url('') ?>" class="form-horizontal" methos="posts">

		<div class="form-group">
    		<label for="nummemo" class="col-sm-2 control-label">Nombre del documento:</label>
    		<div class="col-sm-10">
      			<input type="text" class="form-control" id="nummemo" name="nummemo" placeholder="Por favor ingrese aqui el no. del memo que desea diligenciar" required>
    		</div>
        </div>

        <div class="form-group">
            <label for="nummemo" class="col-sm-2 control-label">Tipo de documento:</label>
            <div class="col-sm-10">
                <select id="type">
                    <option value="memo">Memo</option>
                    <option value="carta">Carta</option>
                    <option value="factura">Factura</option>
                    <option value="otro">otro</option>
                </select>
            </div>
        </div>
        
 		<div class="form-group">
    		<label for="uploader" class="col-sm-2 control-label">Archivo a subir:</label>
    		<div class="col-sm-10">
      			<div id="uploader">
		 			Clic aqui para añadir archivo
		 		</div>
    		</div>
 		</div>
 		<button type="button" class="btn btn-primary" id="subir">Subir a la web</button>
 		 
 		 <hr>
 		 <div id="text-archivos" style="color:red"><b>Archivo subido con exio.</b></div>


	</form>
</div>