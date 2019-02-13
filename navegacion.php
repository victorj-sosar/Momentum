<?php
	require 'funcs/conexion.php';
	include 'funcs/funciones.php';
	session_start();
	$errors = array();
	$erros = array();
	$errores = array();
	// Operaciones para registra el nuevo usuario
	if (isset($_POST['Btn_registrar'])) {
		$nombres = $mysqli->real_escape_string($_POST["Txt_nombres"]);
		$paterno = $mysqli->real_escape_string($_POST["Txt_paterno"]);
		$materno = $mysqli->real_escape_string($_POST["Txt_materno"]);
		$usuario = $mysqli->real_escape_string($_POST["Txt_usuario"]);
		$password = $mysqli->real_escape_string($_POST["Txt_password"]);
		$con_password = $mysqli->real_escape_string($_POST["Txt_password_conf"]);
		$correo = $mysqli->real_escape_string($_POST["Txt_correo"]);
		
		$numero = $mysqli->real_escape_string($_POST["Txt_numero"]);
		$calle = $mysqli->real_escape_string($_POST["Txt_calle"]);
		$colonia = $mysqli->real_escape_string($_POST["Txt_colonia"]);
		$municipio = $mysqli->real_escape_string($_POST["Txt_municipio"]);
		$estado = $mysqli->real_escape_string($_POST["Txt_estado"]);
		
		$direccion = $calle ."#". $numero ." Col. ". $colonia ." ". $municipio .", ". $estado;

		$captcha = $mysqli->real_escape_string($_POST["g-recaptcha-response"]);

		$activo = 0;
		$tipo_usuario = 2;
		$secret = '6LcDyFQUAAAAAKrJVYbaRTKftdosE5CII9SJfb7W';

		if (!$captcha) {
			$errors[] = "Por favor verifica el captcha";
		}
		if (isNull($nombres, $paterno, $materno, $direccion, $correo, $usuario, $password, $con_password)) {
			$errors[] = "Debes de llenar todos los campos";
		}
		if (!isEmail($correo)) {
			$errors[] = "Direccion de correo no valida";
		}
		if (!validaPassword($password, $con_password)) {
			$errors[] = "Las contraseñas no coinciden";
		}
		if (usuarioExiste($usuario)) {
			$errors[] = "El usuario $usuario ya existe";
		}
		if (emailExiste($correo)) {
			$errors[] = "El correo electrónico $correo ya existe";
		}
		if (count($errors) == 0) {
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
			$arr = json_decode($response,TRUE);
			if ($arr["success"]) {
				$pass_hash = hashPassword($password);
				$token = generateToken();
				$registro = registraUsuario($nombres, $paterno, $materno, $direccion, $correo, $usuario, $pass_hash, $activo, $token, $tipo_usuario);
				if ($registro>0) {
					$url = 'http://'.$_SERVER["SERVER_NAME"].'/momentum/activar.php?id='.$registro.'&val='.$token;
					$asunto = 'Activar Cuenta - Momentum-Clothes';
					$cuerpo = "<h1>Estimado $nombres:</h1> <br><br><h2>Para continuar con el proceso de registro, es indispensable dar click en el siguiente enlace</h2> <a href='$url'>Activar Cuenta</a>";
					if (enviarEmail($correo, $nombres, $asunto, $cuerpo)) {
						// exit;
						header("location: index.php");
					}else{
						$erros[] = "Error al enviar Email";
					}
				}else{
					$errors[] = "Error al registrar usuario";
				}
			}else {
				$errors[] = "Error al comprobar captcha";
			}
		}
	}
	// Operaciones para el login de usuario
	if (isset($_POST['Btn_enviar'])) {
		$user = $mysqli->real_escape_string($_POST['Txt_user']);
		$pass = $mysqli->real_escape_string($_POST['Txt_pass']);
		if (isNullLogin($user, $pass)) {
			$erros[] = "Debe llenar todos los campos";
		}
		$erros[] = login($user, $pass);
	}
	//Comprobacion de sesión abierta
	if(isset($_SESSION["log_name"])){ //Si no ha iniciado sesión redirecciona a index.php
		if ($_SESSION['tipo_usuario'] == 1) {
			header("Location: dashboard.php");
		}
	}
	//Operaciones para recuperar contraseña
	if (isset($_POST['Btn_recuperar'])) {
		$email = $mysqli->real_escape_string($_POST['Txt_correo_recupera']);

		if (!isEmail($email)) {
			$errores[] = "Debes ingresar un correo electrónico valido";
		}
		if (emailExiste($email)) {
			$id_user = getValor('id', 'correo', $email);
			$nombres_user = getValor('nombres', 'correo', $email);
			$token = generaTokenPass($id_user);

			$url = 'http://'.$_SERVER["SERVER_NAME"].'/momentum/cambia_pass.php?id_user='.$id_user.'&token='.$token;
			$asunto = 'Recuperar password - Momentum-Clothes';
			$cuerpo = "<h1>Estimado $nombres_user:</h1> <br><br><h2>Se ha solicitado un restablecimiento de contraseña<br>Si usted no ha solicitado esta operación, solo ignore este correo. de lo contrario, visite la siguiente dirección</h2> <a href='$url'>Recuperar contraseña</a>";
			if (enviarEmail($email, $nombres_user, $asunto, $cuerpo)) {
				header("location: index.php");
			}else{
				$errores[] = "Error al enviar Email";
			}
		}else{
			$errores[] = "No existe el correo electrónico";
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link rel="shortcut icon" href="img/logo.ico"/>
	<title>Document</title>
</head>
<body>
	<!-- menú de navegación -->
	<nav class="navbar navbar-toggleable-md navbar-inverse  bg-inverse">
		<div class="container">
			<button class="navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#fm-menu" aria-controls="fm-menu" aria-expanded="false" aria-label="Menu">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="navbar-brand">
				<img src="img/logo.png" width="50px" height="50px">
			</div>

			<div class="collapse navbar-collapse" id="fm-menu">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a href="index.php" id="index" class="nav-link">Inicio</a>
					</li>
					<li class="nav-item">
						<a href="tienda.php" id="tienda" class="nav-link">Tienda</a>
					</li>
					<li class="nav-item">
						<a href="contacto.php" id="contacto" class="nav-link">Contacto</a>
					</li>
					<li class="nav-item">
						<a href="about.php" id="about" class="nav-link">Acerca de</a>
					</li>
						<?php 
							if(isset($_SESSION["id_usuario"])){
								$items = items();
								if ($_SESSION['tipo_usuario']==2) { ?>
									<li class="nav-item">
										<a href="logout.php" class="nav-link">Cerrar sesión</a>
									</li>
									<li class="nav-item">
										<a class="nav-link"><b><span class="icon icon-user"></span><?php echo $_SESSION['log_name']; ?></b></a>
									</li>
									<li class="nav-item car-bg">
										<a href="carrito.php" class="nav-link" id="cart"><span class="icon-cart"></span><span class="items"><strong><?php echo $items; ?></strong></span></a>	
									</li>
								<?php } 
								}else{?>
									<li class="nav-item">
										<a href="" class="nav-link" data-toggle="modal" data-target="#mc-modal-login">Login</a>
									</li>
						<?php } ?>
					</ul>
				<form action="tienda.php" class="form-inline" method="post">
					<div class="form-group">
						<div class="input-group">
								<!-- <span class="input-group-addon icon-user"></span> -->
								<input class="form-control" type="text" name="Txt_search" placeholder="Buscar" required>
								<button type="submit" class="icon icon-search input-group-addon btn btn-primary" name="Btn_buscar" value=""></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</nav>
	<!-- Modal de inicio de sesión -->
	<div class="modal fade" id="mc-modal-login" tabindex="-1" role="dialog" aria-labelledby="mc-modal-login" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Inicio de sesión</h5>
					<button class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container mb-3">
						<div class="row justify-content-center">
							<div class="col logo-center">
								<img src="img/logo.png" width="70px" height="70px">
							</div>
						</div>
					</div>
					<form method="post" id="loginform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon icon-user"></span>
								<input class="form-control" type="text" name="Txt_user" placeholder="Usuario/Correo" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon icon-lock"></span>
								<input class="form-control" type="password" name="Txt_pass" placeholder="Contraseña" required>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" name="Btn_enviar" class="btn btn-outline-primary form-control" value="Iniciar sesión">
						</div>
					</form>
					<div class="input-group">
						<button class="btn btn-link btn-sm " data-toggle="modal" data-target="#mc-modal-rec-contra">Olvidé mi contraseña</button>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-link" disabled>¿No tienes cuenta?</button><button class="btn btn-link btn-sm" data-toggle="modal" data-target="#mc-modal-registro">Registrarse</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Impresion de errores -->
	<?php echo resultBlock($errors)?>
	<?php echo resultBlocks($erros)?>
	<?php echo resultBlockes($errores)?>
	<!-- Modal de recuperación de contraseña -->
	<div class="modal fade" id="mc-modal-rec-contra" tabindex="-1" aria-labelledby="mc-modal-rec-contra" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Recuperar contraseña</h5>
					<button class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container mb-3">
						<div class="row justify-content-center">
							<div class="col logo-center">
								<img src="img/logo.png" width="70px" height="70px">
							</div>
						</div>
					</div>
					<form method="post" id="recontraform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon icon-mail4"></span>
								<input class="form-control" type="email" name="Txt_correo_recupera" placeholder="Correo electrónico" required>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" name="Btn_recuperar" class="btn btn-outline-primary form-control" value="Recuperar contraseña">
						</div>
					</form>
				</div>
				<div class="modal-footer bg-info">
					<div class='alert' id='alerta'>
						<h6><span class="icon icon-bell"></span>Se enviará un correo electrónico para que puedas procedera la recuperacion de tu contraseña, luego de esto, podrás accesar a tu cuenta.</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal de registro de usuario -->
	<div class="modal fade" id="mc-modal-registro" tabindex="-1" role="dialog" aria-labelledby="mc-modal-registro" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Registro de usuario</h5>
					<button class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container mb-3">
						<div class="row justify-content-center">
							<div class="col logo-center">
								<img src="img/logo.png" width="100px" height="100px">
							</div>
						</div>
					</div>
					<form method="post" id="signupform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>">
						<div class="container">
							<div class="row">
								<div class="col-sm-12 col-lg-6">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-user-tie"></span>
											<input class="form-control" type="text" name="Txt_nombres" placeholder="Nombre(s):" value="<?php if(isset($nombres)) echo $nombres; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-user-tie"></span>
											<input class="form-control" type="text" name="Txt_paterno" placeholder="Apellido paterno:" value="<?php if(isset($paterno)) echo $paterno; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-user-tie"></span>
											<input class="form-control" type="text" name="Txt_materno" placeholder="Apellido materno:" value="<?php if(isset($materno)) echo $materno; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-user"></span>
											<input class="form-control" type="text" name="Txt_usuario" placeholder="Usuario:" value="<?php if(isset($usuario)) echo $usuario; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-lock"></span>
											<input class="form-control" type="password" name="Txt_password" placeholder="Contraseña:" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-lock"></span>
											<input class="form-control" type="password" name="Txt_password_conf" placeholder="Comprobar contraseña:" required>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-lg-6">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-mail4"></span>
											<input class="form-control" type="email" name="Txt_correo" placeholder="Correo" value="<?php if(isset($correo)) echo $correo; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-location2"></span>
											<input class="form-control" type="text" name="Txt_calle" placeholder="Calle:" value="<?php if(isset($calle)) echo $calle; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-location2"></span>
											<input class="form-control" type="text" name="Txt_numero" placeholder="Número int/ext:" value="<?php if(isset($numero)) echo $numero; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-location2"></span>
											<input class="form-control" type="text" name="Txt_colonia" placeholder="Colonia:" value="<?php if(isset($colonia)) echo $colonia; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-location2"></span>
											<input class="form-control" type="text" name="Txt_municipio" placeholder="Localidad:" value="<?php if(isset($municipio)) echo $municipio; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon icon-location2"></span>
											<input class="form-control" type="text" name="Txt_estado" placeholder="Entidad federativa" value="<?php if(isset($estado)) echo $estado; ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="g-recaptcha col-md-9" data-sitekey="6LcDyFQUAAAAABeeFotYlT3ibmfHInx6U2Gm5Rrm"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" name="Btn_registrar" class="btn btn-outline-primary form-control" value="Registrarse">
						</div>
					</form>
				</div>
				<div class="modal-footer bg-info">
					<div class='alert' id='alerta'>
						<h6><span class="icon icon-bell"></span>Una vez terminado tu registro, se enviará un correo electrónico de confirmación para que actives tu cuenta.</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>