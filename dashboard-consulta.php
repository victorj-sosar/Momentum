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
				<div class="row contenido" id="consultaC">
					<div class="columna col-12">
						<div class="widget">
							<h3 class="titulo">Consultas</h3>
							<div class="col">
								<ul class="nav nav-tabs mt-5 d-flex flex-wrap">
									<li class="nav-item">
										<a href="#tabUser" class="nav-link active" data-toggle="tab">Usuarios</a>
									</li>
									<li class="nav-item">
										<a href="#tabProduct" class="nav-link" data-toggle="tab">Productos</a>
									</li>
									<li class="nav-item">
										<a href="#tabSale" class="nav-link" data-toggle="tab">Ventas</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active text-justify" id="tabUser" role="tabpanel">
										<?php echo consultaUsuarios(); ?>			
									</div>
									<div class="tab-pane text-justify" id="tabProduct" role="tabpanel">
										<?php echo consultaProductos(); ?>
									</div>
									<div class="tab-pane text-justify" id="tabSale" role="tabpanel">
										<?php echo consultaVenta(); ?>
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
    	$("#consulta").addClass('active');
    </script>
</body>
</html>