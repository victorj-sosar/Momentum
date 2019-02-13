<?php
	require 'funcs/conexion.php';
	require 'funcs/funciones.php';
	$errors = array();
	$succesful = array();
	if (empty($_GET['id_user'])) {
		header('Location: index.php');
	}
	if (empty($_GET['token'])) {
		header('Location: index.php');
	}
	$user_id = $mysqli->real_escape_string($_GET['id_user']);
	$token = $mysqli->real_escape_string($_GET['token']);
	if (!verificaTokenPass($user_id, $token)) {
		echo 'No se pudo verificar los Datos';
		exit;
	}

	// Operaciones para restablecer la contraseña
	if (isset($_POST['Btn_recuperar_pass'])) {
		$user_id = $mysqli->real_escape_string($_POST['user_id']);
		$token = $mysqli->real_escape_string($_POST['token']);
		$pass_rec = $mysqli->real_escape_string($_POST['Txt_pass_rec']);
		$pass_rec_conf = $mysqli->real_escape_string($_POST['Txt_pass_rec_conf']);
		if (validaPassword($pass_rec, $pass_rec_conf)) {
			$pass_hash = hashPassword($pass_rec);
			if (cambiaPassword($pass_hash, $user_id, $token )) {
				$succesful[] = "Password modificado exitosamente";
			}else{
				$errors[] = "Error al modificar el password";
			}
		}else{
			$errors[] = "Las contraseñas no coinciden";
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="img/logo.ico">
	<title>Cambiar contraseña</title>
</head>
<body>
	<div class="container">    
		<div class="row mt-5">
			<div class="col-sm-12 col-md-6 col-lg-8 m-auto">
				<div class="card">
					<img src="img/logo.png" class="card-img-top img-fluid logo-center mt-5 mb-5" width="150px" height="150px">
					<div class="card-block">
						<h5 class="card-title">Restablecer contraseña</h5>
						<form method="post" role="form" action="<?php $_SERVER['PHP_SELF'] ?>">
							<input type="hidden" name="user_id" value ="<?php echo $user_id; ?>" />
							
							<input type="hidden" name="token" value ="<?php echo $token; ?>" />
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon icon-mail4"></span>
									<input class="form-control" type="password" name="Txt_pass_rec" placeholder="Contraseña" required>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon icon-mail4"></span>
									<input class="form-control" type="password" name="Txt_pass_rec_conf" placeholder="Confirmar contraseña" required>
								</div>
							</div>
							<div class="form-group">
								<input type="submit" name="Btn_recuperar_pass" class="btn btn-outline-primary form-control" value="Restablecer contraseña">
							</div>
						</form>
						<?php echo resultDiv($errors)?>
						<?php echo resultDivs($succesful)?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>