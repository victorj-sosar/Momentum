<?php
	require 'funcs/conexion.php';
	require 'funcs/funciones.php';
	if (isset($_GET["id"]) AND isset($_GET["val"])) {
		$idUsuario = $_GET["id"];
		$token = $_GET["val"];
		$mensaje = validaIdToken($idUsuario, $token);
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="shortcut icon" href="img/logo.ico"/>
	<title>Activar cuenta</title>
</head>
<body>
	<div class="container">
		<div class="jumbotron mt-5">
			<h1><?php echo $mensaje; ?></h1>
			<br>
			<p><a class="btn btn-primary btn-lg" role="button" href="index.php">Iniciar sesión</a></p>
		</div>
	</div>
</body>
</html>