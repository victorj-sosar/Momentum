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
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="js/jquery-3.2.1.min.js"></script>
	<style type="text/css">
        ${demo.css}
	</style>
	<script type="text/javascript">
	    $(function () {
	        $('#grafica').highcharts({
	            chart: {
	                type: 'bar'
	            },
	            title: {
	                text: 'Precios de productos'
	            },
	            subtitle: {
	                text: 'Momentum Clotes'
	            },
	            xAxis: {
	                categories: [
	                    <?php
	                    global $mysqli;
	                            
	                    $stmt = $mysqli->prepare("SELECT nombre FROM productos ORDER BY precio_venta ASC");
	                    $stmt->execute();
	                    $stmt->store_result();
	                    $num = $stmt->num_rows;
	                    for ($i=0; $i < $num; $i++) { 
	                        $stmt->bind_result($nombre);
	                        $stmt->fetch();			
	                    ?>
	                    	['<?php echo $nombre ?>'],		
	                    <?php
	                    }
	                    ?>
	    			],
	                title: {
	                    text: null
	                }
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: 'Precio (pesos)',
	                    align: 'high'
	                },
	                labels: {
	                    overflow: 'justify'
	                }
	            },
	            tooltip: {
	                valueSuffix: ' pesos'
	            },
	            plotOptions: {
	                bar: {
	                    dataLabels: {
	                        enabled: true
	                    }
	                }
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'top',
	                x: -40,
	                y: 100,
	                floating: true,
	                borderWidth: 1,
	                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
	                shadow: true
	            },
	            credits: {
	                enabled: false
	            },
	            series: [{
	                name: 'Precio',
	                data: [
	    		        <?php
	                    global $mysqli;
	                    $stmt = $mysqli->prepare("SELECT precio_venta FROM productos ORDER BY precio_venta ASC");
	                    $stmt->execute();
	                    $stmt->store_result();
	                    $num = $stmt->num_rows;
	                    for ($i=0; $i < $num; $i++) { 
	                        $stmt->bind_result($precio);
	                        $stmt->fetch();		
	                    ?>			
	                    	[<?php echo $precio ?>],
	                    		
	                    <?php
	                    }
	                    ?>			
	    			]
	            }]
	        });
	    });
	</script>
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
				<div class="row contenido" id="inicioC">
					<div id="grafica" class="col-12 "></div>
					<div class="columna col-12">
						<div class="widget estadisticas">
							<h3 class="titulo">Estadisticas</h3>
							<div class="contenedor d-flex flex-wrap">
								<div class="caja">
									<h3><?php 
										$num_visitas = 'visitas.txt';
										if (file_exists($num_visitas)) {
											$cuenta = file_get_contents($num_visitas);
											echo $cuenta;
										}
									 ?></h3>
									<p>Visitas</p>
								</div>
								<div class="caja">
									<h3><?php echo usuarios(); ?></h3>
									<p>Clientes</p>
								</div>
								<div class="caja">
									<h3><?php echo productos(); ?></h3>
									<p>Productos</p>
								</div>
								<div class="caja">
									<h3><?php echo "$ ".ingresos(); ?></h3>
									<p>Ingresos</p>
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
	<script src="Highcharts-4.1.5/js/highcharts.js"></script>
    <script src="Highcharts-4.1.5/js/modules/exporting.js"></script>
    <script type="text/javascript">
		$('.menu').children('.active').removeClass('active');
    	$("#inicio").addClass('active');
    </script>
</body>
</html>