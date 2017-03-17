<div>
	<form action="<?= site_url('welcome/mailer') ?>" method="POST" style="padding: 3ex;">
		<legend><h3>Formulario de  recuperacion de contraseña</h3></legend>
		<p class="bg-warning">Si ustes no tiene un usuario registrado o su correo no es válido este servicio generara ninguna repuesta.</p>
		<div class="form-group">
    		<label for="mail">Ingrese su correo relacionado con este servicio: </label>
    		<input type="email" class="form-control" id="mail" placeholder="Ingrese aqui su correo" required>
  		</div>
  		<button type="submit" class="btn btn-default">Enviar >></button>
	</form>	
</div>