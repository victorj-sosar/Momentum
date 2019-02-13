<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Momentum-Clothes</title>
</head>
<body>
	<!-- menu de navegacion -->
	<?php require 'navegacion.php'; ?>
	<script type="text/javascript">
		$('#index').addClass('active');
    </script>
    <?php 
		visitas();
	?>
	<!-- Slideshow de presentación -->
	<div class="carousel slide hidden-sm-down" id="principal-carousel" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#principal-carousel" data-slid-to="0" class="active"></li>
			<li data-target="#principal-carousel" data-slid-to="1"></li>
			<li data-target="#principal-carousel" data-slid-to="2"></li>
			<li data-target="#principal-carousel" data-slid-to="3"></li>
			<li data-target="#principal-carousel" data-slid-to="4"></li>
			<li data-target="#principal-carousel" data-slid-to="5"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="img/slide1.jpg" alt="">
			</div>
			<div class="carousel-item">
				<img src="img/slide2.jpg" alt="">
			</div>
			<div class="carousel-item">
				<img src="img/slide3.jpg" alt="">
			</div>
			<div class="carousel-item">
				<img src="img/slide4.jpg" alt="">
			</div>
			<div class="carousel-item">
				<img src="img/slide5.jpg" alt="">
			</div>
			<div class="carousel-item">
				<img src="img/slide6.jpg" alt="">
			</div>
		</div>

		<a href="#principal-carousel" class="carousel-control-prev" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		</a>

		<a href="#principal-carousel" class="carousel-control-next" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Siguiente</span>
		</a>
	</div>

	<!-- Sección de productos destacados -->
	<div class="container">
		<div class="row mt-5 mb-5">
			<div class="col">
				<h2 class="display-4">Productos destacados</h2>
			</div>
		</div>
		<div class="row">
			<?php
				$a = 0;
				$rand = range(1, 16);
				shuffle($rand);
					foreach ($rand as $val) {
						$a++;
						$img = "img/producto".$val.".png"; 
						$ProName = MostrarProductos($val);?>
						<div class="col-sm-12 col-md-4 col-lg-3 mb-4">
							<div class="card">
								<img src="<?php echo $img ?>" class="card-img-top img-fluid">
						 		<div class="card-block">
						 			<h3 class="card-title"><?php echo $ProName; ?></h3><br>
						 			<a href="producto.php?id=<?php echo $val ;?>" class="btn btn-outline-primary btn-lg btn-block">Ver más</a>
						 		</div>
						 	</div>
						</div>
			<?php 
						if ($a > 7) {
							break;
						}
					}
			?>
		</div>
	</div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>