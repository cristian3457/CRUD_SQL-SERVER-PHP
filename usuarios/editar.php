<!DOCTYPE html> 
<?php 
	include("../database/conexion_sis.php");
	include("../shared/navbar.html");
?>
<html lang="en">
<head>
    <title>Editar Usuario</title>
</head>
<body>
<?php	
	if(isset($_GET['editar'])){
			$editar_id = $_GET['editar'];

			$consulta = "SELECT * FROM usuarios WHERE id='$editar_id'";
			$ejecutar = sqlsrv_query($con, $consulta);

			$fila = sqlsrv_fetch_array($ejecutar);

			$usuario = $fila['usuario'];
			$password = $fila['password'];
			$email = $fila['email'];
			$img = $fila['img'];
		}

?>

<br />

<div class="col-md-8 offset-md-2">
<h1 class="text-uppercase text-center mb-3">Registrar Usuario</h1>
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
				<input type="text" id="nombre" require minlength="4" name="nombre" class="form-control" value="<?php echo $usuario; ?>">
				<div id="validationNombre" class="invalid-feedback" hidden="true">
					<span>Ingresa al menos 4 caracteres </span>
				</div>
			</div>
			<div class="form-group">
				<label>Contraseña:</label>
				<input type="password" id="passw" name="passw" require minlength="8" maxlength="16" class="form-control" value="<?php echo $password; ?>">
				<div id="validationPassw" class="invalid-feedback" hidden="true">
					<span>Ingresa al menos 8 caracteres </span>
				</div>
			</div>
			<div class="form-group">
				<label>Email:</label>
				<input type="email" id="email" name="email" require minlength="4" class="form-control" value="<?php echo $email; ?>">
				<div id="validationEmail" class="invalid-feedback" hidden="true">
					<span>Ingresa un correo valido </span>
				</div>
			</div>
			<div class="form-group text-center">				
				<input type="submit" id="actualizar" name="actualizar" class="btn btn-warning" value="ACTUALIZAR DATOS">
			</div>
		</form>
</div>

<?php

	if(isset($_POST['actualizar'])){
			$actualizar_nombre = $_POST['nombre'];
			$actualizar_password = $_POST['passw'];
			$actualizar_email = $_POST['email'];

			$consulta = "UPDATE usuarios SET usuario='$actualizar_nombre', password='$actualizar_password', email='$actualizar_email' WHERE id='$editar_id'";

			$ejecutar = sqlsrv_query($con, $consulta);

			if($ejecutar){
				$tabla = 'usuarios';
				$campo = 'img';
				$archivo = $_FILES['archivo']['name'];
				if (isset($archivo) && $archivo != "") {
					$id_usuario = $editar_id;
					$nombre_post = 'actualizar';
					require('../upload/subirImagen.php');
				}else{
					?>
					<script>showNotification('top', 'center', 'success', 'Usuario actualizado correctamente');</script>
					<?php
					echo "<script>window.open('listaUsuarios.php', '_self')</script>";
				}
			}			
		}

?>
<script> 
srcImagen = '../images/usuarios/<?php echo $img; ?>';
$('#imgUsuario').attr('src', srcImagen);
nombreValido = true;
emailValido = true;
passwordValido = true;
$("#archivo").on('change', function(e) {
	  if( e.target.files.length > 0 ){
		  // Obtenemos la ruta temporal mediante el evento
		  var TmpPath = URL.createObjectURL(e.target.files[0]);
		  $('#imgUsuario').attr('src', TmpPath);
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
  if( nombreValido && passwordValido && emailValido){
	$('#actualizar').attr('disabled', false);
  }else{
	$('#actualizar').attr('disabled', true);
  }
}
</script>
</body>
</html>