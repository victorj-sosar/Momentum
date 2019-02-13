<?php 
	session_start();
	require 'funcs/conexion.php';
	include 'funcs/funciones.php';
	$errors = array();	
	if(isset($_SESSION["log_name"])){ //Si no ha iniciado sesión redirecciona a index.php
		if ($_SESSION['tipo_usuario'] != 1) {
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
	if (isset($_POST['Btn_registrarp'])) {
		$nombrep = $mysqli->real_escape_string($_POST["Txt_nombre"]);
		$descripcionp = $mysqli->real_escape_string($_POST["Txt_descripcion"]);
		$mdp = $mysqli->real_escape_string($_POST["Txt_md"]);
		$lgp = $mysqli->real_escape_string($_POST["Txt_lg"]);
		$xlp = $mysqli->real_escape_string($_POST["Txt_xl"]);
		$dxlp = $mysqli->real_escape_string($_POST["Txt_2xl"]);
		$txlp = $mysqli->real_escape_string($_POST["Txt_3xl"]);
		$cxlp = $mysqli->real_escape_string($_POST["Txt_4xl"]);
		$unip = $mysqli->real_escape_string($_POST["Txt_unitalla"]);
		$pcostop = $mysqli->real_escape_string($_POST["Txt_p_costo"]);
		$pventap = $mysqli->real_escape_string($_POST["Txt_p_venta"]);		

		registraProducto($nombrep,$descripcionp,$mdp,$lgp,$xlp,$dxlp,$txlp,$cxlp,$unip, $pcostop, $pventap);
	}
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

		$activo = 1;
		$tipo_usuario = 1;
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
					header("Location: dashboard-registro.php");
				}else{
					$errors[] = "Error al registrar usuario";
				}
			}else {
				$errors[] = "Error al comprobar captcha";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="shortcut icon" href="img/logo.ico"/>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,500" rel="stylesheet">
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="js/jquery-3.2.1.min.js"></script>
	<title>Dashboard</title>
</head>
<body class="body">
	<div class="container-fluid">
		<div class="row">
			<div class="barra-lateral col-12 col-sm-auto">
				<div class="logo">
					<?php 
						if(isset($_SESSION["id_usuario"])){
							if ($_SESSION['tipo_usuario']==1) { 
					?>
					<h2><span class="icon icon-user"></span><?php echo $_SESSION['log_name']; ?></h2>
					<?php
							}
						}
					?>
				</div>
				<nav class="menu d-flex d-sm-block justify-content-center flex-wrap">
					<a href="dashboard.php" class="active" id="inicio"><i class="icon-home3"></i><span>Inicio</span></a>
					<a href="dashboard-registro.php" class="" id="registro"><i class="icon-file-text2"></i><span>Registros</span></a>
					<a href="dashboard-consulta.php" class="" id="consulta"><i class="icon-books"></i><span>Consultas</span></a>
					<a class="" id="editar"><i class="icon-pencil"></i><span>Editar</span></a>
					<a href="logout.php"><i class="icon-exit"></i><span>Cerrar sesión</span></a>
				</nav>
			</div>

			<main class="main col">
				<div class="row contenido" id="registroC">
					<div class="columna col-12" id="enter">
						<!-- Impresion de errores -->
						<?php echo resultBlockD($errors)?>
						<div class="widget">
							<h3 class="titulo">Registros</h3>
							<div class="col">
								<ul class="nav nav-tabs mt-5">
									<li class="nav-item">
										<a href="#tab1" class="nav-link active" data-toggle="tab">Administradores</a>
									</li>
									<li class="nav-item">
										<a href="#tab2" class="nav-link" data-toggle="tab">Productos</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active text-justify" id="tab1" role="tabpanel">
										<form method="post" id="signupform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" class="mt-3">
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
																<input class="form-control" type="email" name="Txt_correo" placeholder="Correo:" value="<?php if(isset($correo)) echo $correo; ?>" required>
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
											<div class="form-group">
												<input type="submit" name="Btn_registrar" class="btn btn-outline-primary form-control" value="Registrar usuario">
											</div>
										</form>
									</div>
									<div class="tab-pane text-justify" id="tab2" role="tabpanel">
										<form method="post" id="productform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" class="mt-3">
												<div class="row">
													<div class="col-sm-12 col-lg-6">
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-dice"></span>
																<input class="form-control" type="text" name="Txt_nombre" placeholder="Nombre del producto:" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-pencil"></span>
																<textarea class="form-control" type="text" name="Txt_descripcion" placeholder="Descripción:" value="" required></textarea>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_md" placeholder="Talla mediana (unidades):" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_lg" placeholder="Talla grande (unidades):" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_xl" placeholder="Talla xl (unidades):" value="" required>
															</div>
														</div>
													</div>
													<div class="col-sm-12 col-lg-6">
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_2xl" placeholder="Talla 2xl (unidades):" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_3xl" placeholder="Talla 3xl (unidades):" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_4xl" placeholder="Talla 4xl (unidades):" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-enlarge"></span>
																<input class="form-control" type="text" name="Txt_unitalla" placeholder="Unitalla (unidades):" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-coin-dollar"></span>
																<input class="form-control" type="text" name="Txt_p_costo" placeholder="Precio de costo:" value="" required>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon icon-coin-dollar"></span>
																<input class="form-control" type="text" name="Txt_p_venta" placeholder="Precio de venta:" value="" required>
															</div>
														</div>
													</div>
												</div>
											<div class="form-group">
												<input type="submit" name="Btn_registrarp" class="btn btn-outline-primary form-control" value="Registrar producto">
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$('.menu').children('.active').removeClass('active');
    	$("#registro").addClass('active');
    </script>
</body>
</html>