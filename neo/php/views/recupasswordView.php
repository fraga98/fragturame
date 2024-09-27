<?php
//require_once '../php/utilidades/required.php';
//require_once 'template/head.php';
?>
<h1>Recuperar password</h1>
<div class="">
	<form action="<?php echo URL_LOGICA_USUARIO_RECORDAR_PASSWORD ?>" method="POST" class="bg-primary" style="height: 50vh;">
		<div class="form-group mt-3">
          	<label for="email" class="text-white">Email</label>
            <input id="email" type="email" name="email" class="form-control border border-white inputs mt-1" aria-describedby="emailHelp" placeholder="Ingrese email..." value="softwabot@gmail.com">
        </div>
        <div class="form-group mt-3">
          	<label for="password" class="text-white">Password</label>
            <input id="password" type="password" name="password" class="form-control border border-white inputs mt-1" placeholder="" value="123456+">
        </div>
         <div class="form-group mt-3">
          	<label for="password" class="text-white">Password Confirmación</label>
            <input id="password" type="password" name="confirmapassword" class="form-control border border-white inputs mt-1" placeholder="" value="123456+">
        </div>
        <button type="submit" class="col-12 mt-5 bg-danger">Guardar Cambios</button>
	</form>
</div>
