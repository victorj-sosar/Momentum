<?php 
	if (isset($_GET["id"])) {
		$idProducto = $_GET["id"];
	}
	else{
		header("Location: tienda.php");
	}
	$err = "";
	$e = "";
	$exis = "";
	if (isset($_GET["error"])) {
		$e = $_GET["error"];
	}
	if (isset($_GET["exis"])) {
		$exis = $_GET["exis"];
	}
	if ($e == 1) {
		$err = "Debes iniciar sesión o registrarte<br>Da click aquí";
	}
	if ($e == 2) {
		$err = "Unidades de producto no disponibles en la talla especificada.<br>Unidades en stock: $exis";
	}
	if ($e == 3) {
		$err = "Por favor selecciona una talla y/o unidades validas";
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Descripción</title>
</head>
<body>
	<!-- Menú de navegación -->
	<?php require 'navegacion.php'; ?>

	<?php if ($e == 1): ?>
		<a class='msg_error' data-toggle='modal' data-target='#mc-modal-login'>
			<div id='error' class='alert alert-danger' role='alert'>
				<ul>
					<li><?php echo $err; ?></li>
				</ul>
			</div>
		</a>
	<?php endif ?>
	<?php if ($e == 2): ?>
			<div id='alert' class='alert alert-danger' role='alert'>
				<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $err; ?>
			</div>
	<?php endif ?>
	<?php if ($e == 3): ?>
			<div id='alert' class='alert alert-info' role='alert'>
				<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $err; ?>
			</div>
	<?php endif ?>
	<!-- contenido de la pagina -->
	 	<div class="container">
	 		<div class="row mt-5">
	 			<div class="col-xs-12 col-md-6">
	 				<figure class="figure">
	 					<img class="img-fluid" src= <?php echo "img/producto". $idProducto. ".png"?>>
	 				</figure>
	 			</div>
	 			<div class="col-xs-12 col-md-6">
	 				<?php ComprarProductos($idProducto); ?>
	 			</div>
	 		</div>
	 	</div>
	<!-- Footer -->
	<?php require 'footer.php'; ?>
	<script type="text/javascript">
		$('.navbar-nav').children('.active').removeClass('active');
		$('#tienda').addClass('active');
    </script>
</body>
</html>