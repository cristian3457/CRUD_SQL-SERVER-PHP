<!DOCTYPE html> 
<?php 
	include("../database/conexion_sis.php");
	include("../shared/navbar.html");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Registrar Usuario</title>
</head>
<body>
<div class="col-md-8 offset-md-2">
		<h1 class="text-uppercase text-center">Registrar Usuario</h1>

		<form method="POST" action="registrarUsuario.php">
			<div class="form-group">
				<label>Nombre:</label>
				<input type="text" name="nombre" class="form-control" placeholder="Escriba su nombre"><br />
			</div>
			<div class="form-group">
				<label>Contraseña:</label>
				<input type="password" name="passw" class="form-control" placeholder="Escriba su contraseña"><br />
			</div>
			<div class="form-group">
				<label>Email:</label>
				<input type="email" name="email" class="form-control" placeholder="Escriba su email"><br />
			</div>
			<div class="form-group text-center">				
				<input type="submit" name="insert" class="btn btn-warning" value="INSERTAR DATOS"><br />
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
				echo "<script>alert('Usuario registrado correctamente')</script>";
				echo "<script>window.open('listaUsuarios.php', '_self')</script>";
			}

		}

	?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>