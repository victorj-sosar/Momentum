<?php
	if (isset($_POST['Btn_enviarC'])) {
		$correo = $_POST["Txt_correoC"];
		$nombre = $_POST["Txt_nombreC"];
		$cuerpo = $_POST["Txt_areaC"];
		require_once 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ));

		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->Username = 'clothesmomentum@gmail.com';
		$mail->Password = 'darkus123';
		$mail->setFrom('clothesmomentum@gmail.com',$nombre);
		$mail->addAddress('clothesmomentum@gmail.com', $nombre);
		
		$mail->Subject = "Contacto";
		$mail->Body    = $cuerpo . "<br><br><br>Contacto personal: " . $correo;
		$mail->IsHTML(true);
		
		if($mail->send()){
			header("Location: index.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Contacto</title>
</head>
<body>
	<!-- Menú de navegación -->
	<?php require 'navegacion.php'; ?>
	<!-- cuerpo de la pagina -->
	<div class="container mt-5">
		<p class="display-4">Contacto</p>
		<div class="row justify-content-center mt-5">
				<div class="col-12 col-lg-5">
					<div class="container mb-3">
						<div class="row justify-content-center">
							<div class="col logo-center">
								<img src="img/logo.png" width="100px" height="100px">
							</div>
						</div>
					</div>
					<form method="post" id="recontraform" role="form" action="contacto.php">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon icon-user"></span>
								<input class="form-control" type="text" name="Txt_nombreC" placeholder="Nombre(s):" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon icon-mail4"></span>
								<input class="form-control" type="email" name="Txt_correoC" placeholder="Correo electrónico:" required>
							</div>
						</div>
						<div class="form-group">
							<textarea name="Txt_areaC" class="form-control" placeholder="Texto" required></textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="Btn_enviarC" class="btn btn-outline-primary form-control" value="Enviar">
						</div>
					</form>
				</div>
			</div>
	</div>
	<!-- Footer -->
	<?php require 'footer.php'; ?>
	<script type="text/javascript">
		$('.nav-item').children('.active').removeClass('active');
		$('#contacto').addClass('active');
    </script>
</body>
</html>