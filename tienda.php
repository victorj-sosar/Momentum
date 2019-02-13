<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Tienda</title>
</head>
<body>
	<!-- Menú de navegación -->
	<?php require 'navegacion.php'; ?>
	<!-- Contenido de productos -->
	<div class="container mt-5">
		<div class="row mt-5 mb-5">
			<div class="col">
				<h2 class="display-4">Productos</h2>
			</div>
		</div>
		<div class="row">
			<?php if (isset($_POST["Btn_buscar"])): ?>
			<?php
			global $mysqli;
			$busqueda = "%{$_POST['Txt_search']}%";
			$stmt = $mysqli->prepare("SELECT id, nombre FROM productos WHERE nombre LIKE ?");
			$stmt->bind_param('s',$busqueda);
			if ($stmt->execute()) {
				$stmt->store_result();
				$num = $stmt->num_rows;
				if ($num > 0) {
					for ($i=1; $i <= $num ; $i++) { 
					$stmt->bind_result($Pid,$Pnombre);
					$stmt->fetch();
					$img = "img/producto".$Pid.".png";?>
					<div class="col-sm-12 col-md-4 col-lg-3 mb-4">
						<div class="card">
							<img src="<?php echo $img ?>" class="card-img-top img-fluid" alt="">
					 		<div class="card-block">
					 			<h3 class="card-title"><?php echo $Pnombre; ?></h3>
					 			<a href="producto.php?id=<?php echo $Pid ;?>" class="btn btn-outline-primary btn-lg btn-block">Ver más</a>
					 		</div>
					 	</div>
					</div>
			<?php
					}
				}
				else{
					echo "<div class='jumbotron mt-5 mr-auto ml-auto d-flex flex-column'>
						<p class='h1 mb-5'>No se econtraron coincidencias en los productos</p>
						<a class='btn btn-outline-primary btn-lg ml-auto mr-auto mt-5' role='button' href='tienda.php'>Ver productos</a>
					</div>";
				}
			}  ?>
					
			<?php else: ?>
				<?php
				$stmt = $mysqli->prepare("SELECT * from productos");
				$stmt->execute();
				$stmt->store_result();
				$items = $stmt->num_rows;
				for ($i=1; $i <= $items; $i++) { 
					$img = "img/producto".$i.".png"; 
					$ProName = MostrarProductos($i);?>
					<div class="col-sm-12 col-md-4 col-lg-3 mb-4">
						<div class="card">
							<img src="<?php echo $img ?>" class="card-img-top img-fluid" alt="">
					 		<div class="card-block">
					 			<h3 class="card-title"><?php echo $ProName; ?></h3>
					 			<a href="producto.php?id=<?php echo $i ;?>" class="btn btn-outline-primary btn-lg btn-block">Ver más</a>
					 		</div>
					 	</div>
					</div>
				<?php 
				}
				?>
			<?php endif ?>
		</div>
	</div>
	<!-- Footer -->
	<?php require 'footer.php'; ?>
	<script type="text/javascript">
		$('.nav-item').children('.active').removeClass('active');
		$('#tienda').addClass('active');
    </script>
</body>
</html>