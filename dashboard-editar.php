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
	if (!isset($_GET["id_producto"]) && !isset($_GET["id_usuario"])) {
		header("Location: dashboard-consulta.php");
	}
	if (isset($_GET["id_producto"])) {
		$idP = $_GET["id_producto"];
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT nombre,descripcion,md,lg,xl,2xl,3xl,4xl,unitalla,precio_costo,precio_venta FROM productos WHERE id = ?");
		$stmt->bind_param('i',$idP);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($nombre,$descripcion,$md,$lg,$xl,$dxl,$txl,$cxl,$unitalla,$precio_costo,$precio_venta);
		$stmt->fetch();
	}
	if (isset($_GET["id_usuario"])) {
		$idU = $_GET["id_usuario"];	
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT nombres,paterno,materno,direccion,correo,usuario FROM usuarios WHERE id = ?");
		$stmt->bind_param('i',$idU);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($nombres,$paterno,$materno,$direccion,$correo,$usuario);
		$stmt->fetch();
	}
	if (isset($_POST["Btn_modificar_user"])) {
		$mnombre = $_POST["Txt_nombres"];
		$mpaterno = $_POST["Txt_paterno"];
		$mmaterno = $_POST["Txt_materno"];
		$musuario = $_POST["Txt_usuario"];
		$mcorreo = $_POST["Txt_correo"];
		$mdireccion = $_POST["Txt_direccion"];

		$captcha = $_POST["g-recaptcha-response"];

		if (!$captcha) {
			$errors[] = "Por favor verifica el captcha";
		}
		if (count($errors)==0) {
			$idU = $_GET["id_usuario"];	
			global $mysqli;
			$stmt = $mysqli->prepare("UPDATE usuarios SET nombres=?,paterno=?,materno=?,direccion=?,correo=?,usuario=? WHERE id = ?");
			$stmt->bind_param('ssssssi',$mnombre,$mpaterno,$mmaterno,$mdireccion,$mcorreo,$musuario,$idU);
			if ($stmt->execute()) {
				header("Location: dashboard.php");
			}
		}
	}
	if (isset($_POST["Btn_modificar_prod"])) {
		$idP = $_GET["id_producto"];
		$pnombre = $_POST["Txt_nombre"];
		$pdescripcion = $_POST["Txt_descripcion"];
		$pmd = $_POST["Txt_md"];
		$plg = $_POST["Txt_lg"];
		$pxl = $_POST["Txt_xl"];
		$p2xl = $_POST["Txt_2xl"];
		$p3xl = $_POST["Txt_3xl"];
		$p4xl = $_POST["Txt_4xl"];
		$puni = $_POST["Txt_unitalla"];
		$pcosto = $_POST["Txt_p_costo"];
		$pventa = $_POST["Txt_p_venta"];
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE productos SET nombre=?, descripcion=?, md=?, lg=?, xl=?, 2xl=?, 3xl=?, 4xl=?, unitalla=?, precio_costo=?, precio_venta=? WHERE id=?");
		$stmt->bind_param('ssiiiiiiiiii',$pnombre,$pdescripcion,$pmd,$plg,$pxl,$p2xl,$p3xl,$p4xl,$puni,$pcosto,$pventa,$idP);
		if ($stmt->execute()) {
			header("Location: dashboard.php");
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
				<div class="row contenido" id="editarC">
					<div class="columna col-12" id="enter">
						<?php echo resultBlockD($errors) ?>
						<div class="widget">
							<h3 class="titulo">Modificar</h3>
							<div class="col">
								<ul class="nav nav-tabs mt-5">
									<li class="nav-item">
										<?php if (isset($_GET["id_usuario"])): ?>
											<a href="#tab1" class="nav-link active" data-toggle="tab" id="usera">Usuarios</a>
										<?php endif ?>
										
									</li>
									<li class="nav-item">
										<?php if (isset($_GET["id_producto"])): ?>
											<a href="#tab2" class="nav-link active" data-toggle="tab" id="producta">Productos</a>
										<?php endif ?>
									</li>
								</ul>
								<div class="tab-content ">
									<?php if (isset($_GET["id_usuario"])): ?>
										<div class="tab-pane text-justify active" id="tab1" role="tabpanel">
											<form method="post" id="signupform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" class="mt-3">
													<div class="row">
														<div class="col-sm-12 col-lg-6 m-auto">
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-user-tie"></span>
																	<input class="form-control" type="text" name="Txt_nombres" placeholder="Nombre(s):" value="<?php
																	echo $nombres ;?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-user-tie"></span>
																	<input class="form-control" type="text" name="Txt_paterno" placeholder="Apellido paterno:" value="<?php
																	echo $paterno ;?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-user-tie"></span>
																	<input class="form-control" type="text" name="Txt_materno" placeholder="Apellido materno:" value="<?php
																	echo $materno ;?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-user"></span>
																	<input class="form-control" type="text" name="Txt_usuario" placeholder="Usuario:" value="<?php
																	echo $usuario ;?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-mail4"></span>
																	<input class="form-control" type="email" name="Txt_correo" placeholder="Correo:" value="<?php
																	echo $correo ;?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-location2"></span>
																	<textarea class="form-control" type="text" name="Txt_direccion" placeholder="Dirección:" value="" required><?php
																	echo $direccion ;?></textarea>
																</div>
															</div>
															<div class="form-group">
																<div class="g-recaptcha col-md-9" data-sitekey="6LcDyFQUAAAAABeeFotYlT3ibmfHInx6U2Gm5Rrm"></div>
															</div>
															<div class="form-group">
																<input type="submit" name="Btn_modificar_user" class="btn btn-outline-primary form-control" value="Modificar usuario">
															</div>
														</div>
													</div>
											</form>
										</div>
									<?php endif ?>
									<?php if (isset($_GET["id_producto"])): ?>
										<div class="tab-pane text-justify active" id="tab2" role="tabpanel">
											<form method="post" id="productform" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" class="mt-3">
													<div class="row">
														<div class="col-sm-12 col-lg-6">
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-dice"></span>
																	<input class="form-control" type="text" name="Txt_nombre" placeholder="Nombre del producto:" value="<?php echo $nombre ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-pencil"></span>
																	<textarea class="form-control" type="text" name="Txt_descripcion" placeholder="Descripción:" value="" required><?php echo $descripcion ; ?></textarea>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_md" placeholder="Talla mediana (unidades):" value="<?php echo $md ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_lg" placeholder="Talla grande (unidades):" value="<?php echo $lg ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_xl" placeholder="Talla xl (unidades):" value="<?php echo $xl ; ?>" required>
																</div>
															</div>
														</div>
														<div class="col-sm-12 col-lg-6">
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_2xl" placeholder="Talla 2xl (unidades):" value="<?php echo $dxl ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_3xl" placeholder="Talla 3xl (unidades):" value="<?php echo $txl ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_4xl" placeholder="Talla 4xl (unidades):" value="<?php echo $cxl ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-enlarge"></span>
																	<input class="form-control" type="text" name="Txt_unitalla" placeholder="Unitalla (unidades):" value="<?php echo $unitalla ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-coin-dollar"></span>
																	<input class="form-control" type="text" name="Txt_p_costo" placeholder="Precio de costo:" value="<?php echo $precio_costo ; ?>" required>
																</div>
															</div>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon icon-coin-dollar"></span>
																	<input class="form-control" type="text" name="Txt_p_venta" placeholder="Precio de venta:" value="<?php echo $precio_venta ; ?>" required>
																</div>
															</div>
														</div>
													</div>
												<div class="form-group">
													<input type="submit" name="Btn_modificar_prod" class="btn btn-outline-primary form-control" value="Modificar producto">
												</div>
											</form>
										</div>
									<?php endif ?>
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
    	$("#editar").addClass('active');
    </script>
</body>
</html>