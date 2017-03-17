<div>
	<button onclick="history.back()" class="btn btn-default">Volver</button>
	<script type="text/javascript">
		var archivo = false;

		 function opt(){
	        var data = {
	            url:"<?= site_url('aprobacion/add') ?>",
	            fileName:"file",
	            allowedTypes:"pdf,doc,docx",
	            showProgress: true,
	            autoSubmit:false,
	            dynamicFormData: function(){
	                    return {
	                        tipo: $("#type").val(),
	                        obser: $("#observacion").val(),
	                        idper: '<?= $per->identificacion ?>',
	                        idpc: '<?= $idpercar ?>',
	                        resu: '<?= $this->session->userdata("idusuario") ?>',
                            base: '<?= $this->session->userdata("base_idbase") ?>'
	                    } 
	                },
	            onSelect: function(files){
	            	if(files.length){
	            		archivo = true;
	            	}
	            },
	            onSubmit:function(files){
	            	
	            },
	            onSuccess:function(files,data,xhr){
	                window.location.href= "<?= site_url('perfil/ver/'.$per->identificacion) ?>";
	            },
	            onError: function(files,status,Msg){
	                alert(JSON.stringify(Msg)+" "+JSON.stringify(status)+" "+JSON.stringify(files));
	            }
	        }
	        return data;
	    }

	    function opt2(){
	    	var myjson = {
	    		tipo: $("#type").val(), 
	    		obser: $("#observacion").val(), 
	    		idper: '<?= $per->identificacion ?>', 
	    		idpc: '<?= $idpercar ?>', 
	    		resu: '<?= $this->session->userdata("idusuario") ?>', 
	    		base: '<?= $this->session->userdata("base_idbase") ?>'
	    	};
	    	if($("#observacion").val() == '' || $("#observacion").val() ==  undefined){
	    		alert("Si no va a anexar un documento necesita tener al menos una observacion y estar en no aprobado.");
	    	}else if($("#type").val() != 2){
	    		alert("Esta intentando crear una aprobacion sin tener un documento de respaldo")
	    	}else{

		    	$.ajax({
		    		url: "<?= site_url('aprobacion/add2') ?>",
	                type: "post",
	                dataType: "json",
	                data: myjson,
	                success: function(msj){
	                	window.location.href = '<?= site_url('perfil/ver/'.$per->identificacion) ?>';
	                },
	                error: function(msj, est, th){
	                	alert(JSON.stringify(msj)+" | "+est+", "+th)
	                	//window.location.href = '<?= site_url('perfil/ver'.$per->identificacion) ?>';
	                }
		    	});
	    	}
	    }

	    $(document).ready(function(){
	    	var uploadObj  = $("#uploader").uploadFile(opt());
	    	$("#subir").on("click",function(){
	    		if(archivo){
	    			alert("1")
	    			uploadObj.startUpload();
	    		}else{
	    			opt2();
	    		}
	    	});
	    });

	</script>
	<form style="width:90%; margin: 0 auto; padding: 2ex;" action="<?= site_url('aprobacion/add') ?>" method="post" enctype="multipart/form-data">
		<legend><h2>formulario de gestión de aprobaciones de cargos
		</h2></legend>
		<div>
			<label>C.C:</label> &nbsp; <span ><?= $per->identificacion; ?></span><br>
			<label>NOMBRE:</label> &nbsp; &nbsp; <span style="color:blue; text-transform: uppercase"><?= $per->primer_nombre." ".$per->segundo_nombre.", ".$per->primer_apellido." ".$per->segundo_apellido; ?></span>
		</div>
		<div>
			<label>CARGO:</label> &nbsp; <span style="color:blue; text-transform: uppercase"><?= $carg->nombre; ?></span>
		</div>

		<hr>

		<div class="form-group">
		    <label for="type" style="color:red">Escoja si el documento es de aprobación o no aprobado:</label>
		    <select class="form-control" name="type" id="type">
		    	<option value="1">Aprobado</option>
		    	<option value="2">No aprobado</option>
		    </select>
  		</div>
		<div class="form-group">
    		<label for="uploader" style="color:red" class="col-sm-2 control-label">Archivo a subir:</label>
    		<div class="col-sm-10">
      			<div id="uploader">
		 			Clic aqui para añadir archivo
		 		</div>
    		</div>
 		</div>
 		<br>
 		<div class="form-group">
 			<label>Observacion:</label>
 			<textarea class="form-control" name="observacion" id="observacion"></textarea>
 		</div>
 		<button type="button" class="btn btn-primary" id="subir">Subir a la web</button>
 		 
	</form>
</div>