<!DOCTYPE html> 
<?php 
	include("../database/conexion_sis.php");
	include("../shared/navbar.html");
?>
<html lang="en">
<head>
    <title>Registrar Usuario</title>
</head>
<body>
<div class="col-md-8 offset-md-2">
		<h1 class="text-uppercase text-center">Registrar Usuario</h1>
		<form method="POST" enctype="multipart/form-data" class="mt-5">
			<div class="row ml-2 mb-4">
				<div class="custom-file col-12 col-md-9">
					<input type="file" class="custom-file-input" name="archivo" id="archivo">
					<label class="custom-file-label" for="archivo">Imagen Usuario</label>
				</div>
				<div class="col-12 col-md-3">
                    <img class="img-thumbnail w-25" id="imgUsuario" src="../images/noImage/no-image.jpg" alt="imagen seleccionada">
                </div>
			</div>
			<div class="form-group">
				<label>Nombre:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" require minlength="4" placeholder="Escriba su nombre">
				<div id="validationNombre" class="invalid-feedback" hidden="true">
					<span>Ingresa al menos 4 caracteres </span>
				</div>
			</div>
			<div class="form-group">
				<label>Contraseña:</label>
				<input type="password" id="passw" name="passw" class="form-control" require minlength="8" maxlength="16" placeholder="Escriba su contraseña">
				<div id="validationPassw" class="invalid-feedback" hidden="true">
					<span>Ingresa al menos 8 caracteres </span>
				</div>
			</div>
			<div class="form-group">
				<label>Email:</label>
				<input type="email" id="email" name="email" class="form-control" require minlength="4" placeholder="Escriba su email">
				<div id="validationEmail" class="invalid-feedback" hidden="true">
					<span>Ingresa un correo valido </span>
				</div>
			</div>
			<div class="form-group text-center">				
				<input id="insertar" type="submit" name="insert" class="btn btn-warning" value="INSERTAR DATOS">
			</div>
		</form>
	</div>
<br /><br /><br />

	<?php
	if(isset($_POST['insert'])){
		$usuario = $_POST['nombre'];
		$pass = $_POST['passw'];
		$email = $_POST['email'];

		$insertar = "INSERT INTO  usuarios(usuario, password, email)VALUES('$usuario', '$pass', '$email')";

		$ejecutar = sqlsrv_query($con, $insertar);
		if($ejecutar){
			$id = sqlsrv_query($con, 'SELECT MAX(id) FROM usuarios'); 
			$datos = sqlsrv_fetch_array($id);
			$id = implode($datos);
			$longitud = ceil(strlen($id)/2);
			$id_usuario = substr( $id , 0 , $longitud );
			$tabla = 'usuarios';
			$campo = 'img';
			$nombre_post = 'insert';
			require('../upload/subirImagen.php');
		}
	}
			
	?>
<script>
hayArchivo = false;
nombreValido = false;
emailValido = false;
passwordValido = false;

$('#insertar').attr('disabled', true);
  $("#archivo").on('change', function(e) {
	  if( e.target.files.length > 0 ){
		  // Obtenemos la ruta temporal mediante el evento
		  var TmpPath = URL.createObjectURL(e.target.files[0]);
		  hayArchivo = true;
		  $('#imgUsuario').attr('src', TmpPath);
	  }else{
		hayArchivo = false;
	  }
	  habilitaBoton();
  });
  $("#nombre").keyup(function(e) {
	var nombre = $(this).val();
	if(nombre.length < 4){
		$("#nombre").addClass('is-invalid');
		$("#validationNombre").attr('hidden', false);
		nombreValido = false;
	}else{
		$("#nombre").removeClass('is-invalid');
		$("#nombre").addClass('is-valid');
		nombreValido = true;
	}
	habilitaBoton();
  });
  $("#passw").keyup(function(e) {
	var passw = $(this).val();
	if(passw.length < 8){
		$("#passw").addClass('is-invalid');
		$("#validationPassw").attr('hidden', false);
		passwordValido = false;
	}else{
		$("#passw").removeClass('is-invalid');
		$("#passw").addClass('is-valid');
		passwordValido = true;
	}
	habilitaBoton();
  });
  $("#email").keyup(function(e) {
	var email = $(this).val();
	var expregEmail = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
	if(!expregEmail.test(email)){
		$("#email").addClass('is-invalid');
		$("#validationEmail").attr('hidden', false);
		emailValido = false;
	}else{
		$("#email").removeClass('is-invalid');
		$("#email").addClass('is-valid');
		emailValido = true;
	}
	habilitaBoton();
  });
function habilitaBoton(){
  if( nombreValido && passwordValido && emailValido && hayArchivo ){
	$('#insertar').attr('disabled', false);
  }else{
	$('#insertar').attr('disabled', true);
  }
}
</script>
</body>
</html>