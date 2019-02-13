<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Carrito</title>
</head>
<body>
	<!-- Menú de navegación -->
	<?php require 'navegacion.php'; ?>
	<!-- contenido de la pagina -->
	<div class="container mt-5">
		<?php if (isset($_SESSION["id_usuario"])): $Uid = $_SESSION["id_usuario"]; ?>
			<p class="display-4 mb-5">Carrito</p>
		 	<div class="row">
		 		<?php carrito($Uid);?>
		 	</div>			
		<?php endif ?>

	</div>	 	
	<!-- Footer -->
	<?php require 'footer.php'; ?>
	<script type="text/javascript">
		$('.navbar-nav').children('.active').removeClass('active');
		$('#cart').addClass('active');
    </script>
</body>
</html>