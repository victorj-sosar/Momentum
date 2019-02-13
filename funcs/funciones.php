<?php
	function visitas()
	{
		$num_visitas = 'visitas.txt';
		if (file_exists($num_visitas)) {
			$cuenta = file_get_contents($num_visitas) + 1;
			file_put_contents($num_visitas, $cuenta);
			return $cuenta;
		} else {
			file_put_contents($num_visitas, 1);
			return 1;
		}
	}
	function isNull($nombres, $paterno, $materno, $direccion, $correo, $usuario, $password, $con_password){
		if(strlen(trim($nombres)) < 1 || strlen(trim($paterno)) < 1 || strlen(trim($materno)) < 1 || strlen(trim($direccion)) < 1 || strlen(trim($correo)) < 1 || strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1 || strlen(trim($con_password)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
		
	function isEmail($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	
	function validaPassword($var1, $var2){
		if (strcmp($var1, $var2) !== 0){
			return false;
			} else {
			return true;
		}
	}
	
	function minMax($min, $max, $valor){
		if(strlen(trim($valor)) < $min)
		{
			return true;
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function usuarioExiste($usuario){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}
	
	function emailExiste($email){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function generateToken(){
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen;
	}
	
	function hashPassword($password){
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}
	function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<a class='msg_error' data-toggle='modal' data-target='#mc-modal-registro'><div id='error' class='alert alert-danger' role='alert'>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div></a>";
		}
	}
	function resultBlockD($errors){
		if(count($errors) > 0)
		{
			echo "<a class='msg_error'><div id='error' class='alert alert-danger' role='alert'>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div></a><br>";
		}
	}
	function resultBlocks($erros){
		if(count($erros) > 0)
		{
			echo "<a class='msg_error' data-toggle='modal' data-target='#mc-modal-login'><div id='error' class='alert alert-danger' role='alert'>
			<ul>";
			foreach($erros as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div></a>";
		}
	}
	function resultBlockes($erros){
		if(count($erros) > 0)
		{
			echo "<a class='msg_error' data-toggle='modal' data-target='#mc-modal-rec-contra'><div id='error' class='alert alert-danger' role='alert'>
			<ul>";
			foreach($erros as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div></a>";
		}
	}
	function resultDiv($erros){
		if(count($erros) > 0)
		{
			echo "<a class='msg_error'><div id='error' class='alert alert-danger' role='alert'>
			<ul>";
			foreach($erros as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div></a>";
		}
	}
	function resultDivs($success){
		if(count($success) > 0)
		{
			echo "<a href= 'index.php' class='msg_error'><div id='error' class='alert alert-success' role='alert'>
			<ul>";
			foreach($success as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div></a>";
		}
	}
	function registraProducto($nombre, $descripcion, $md, $lg, $xl, $dxl, $txl, $cxl, $uni, $pcosto, $pventa){
		
		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO productos (nombre, descripcion, md, lg, xl, 2xl, 3xl, 4xl, unitalla, precio_costo, precio_venta) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('ssiiiiiiiss', $nombre, $descripcion, $md, $lg, $xl, $dxl, $txl, $cxl, $uni, $pcosto, $pventa);
		$stmt->execute();	
	}
	function registraUsuario($nombres, $paterno, $materno, $direccion, $correo, $usuario, $pass_hash, $activo, $token, $tipo_usuario){
		
		global $mysqli;
		$id = 1;

		$reg = $mysqli->query("SELECT * FROM usuarios");
		while (mysqli_fetch_assoc($reg)) {
			$id++;
		}

		$stmt = $mysqli->prepare("INSERT INTO usuarios (id,nombres, paterno, materno, direccion, correo, usuario, password, activacion, token, id_tipo) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('isssssssisi', $id, $nombres, $paterno, $materno, $direccion, $correo, $usuario, $pass_hash, $activo, $token, $tipo_usuario);
		
		if ($stmt->execute()){
			return $id;
			} else {
			return 0;	
		}		
	}
	
	function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
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
		
		$mail->setFrom('clothesmomentum@gmail.com','Momentum-Clothes');
		$mail->addAddress($email, $nombre);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;
	}
	
	function validaIdToken($id, $token){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
		$stmt->bind_param("is", $id, $token);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			$stmt->bind_result($activacion);
			$stmt->fetch();
			
			if($activacion == 1){
				$msg = "La cuenta ya se activo anteriormente.";
				} else {
				if(activarUsuario($id)){
					$msg = 'Cuenta activada.';
					} else {
					$msg = 'Error al Activar Cuenta';
				}
			}
			} else {
			$msg = 'No existe el registro para activar.';
		}
		return $msg;
	}
	
	function activarUsuario($id){
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	function isNullLogin($usuario, $password){
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function login($usuario, $password){
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT id, id_tipo, password, nombres FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param("ss", $usuario, $usuario);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		if($rows > 0) {
			if(isActivo($usuario)){	
				$stmt->bind_result($id, $id_tipo, $passwd, $log_name);
				$stmt->fetch();
				$validaPassw = password_verify($password, $passwd);
				if($validaPassw){
					lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					$_SESSION['log_name'] = $log_name;
					
					header("location: index.php");
				} else {
					
					$erros = "La contraseña es incorrecta";
				}
			} else {
					$erros = 'El usuario no esta activo';
			}
		} else {
			$erros = "El nombre de usuario o correo electrónico no existe";
		}
		return $erros;
	}
	
	function lastSession($id){
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET last_sesion=NOW(), token_password='', password_request=0 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$stmt->close();
	}
	
	function isActivo($usuario){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param('ss', $usuario, $usuario);
		$stmt->execute();
		$stmt->bind_result($activacion);
		$stmt->fetch();
		
		if ($activacion == 1)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}	
	
	function generaTokenPass($user_id){
		global $mysqli;
		
		$token = generateToken();
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");
		$stmt->bind_param('ss', $token, $user_id);
		$stmt->execute();
		$stmt->close();
		
		return $token;
	}
	
	function getValor($campo, $campoWhere, $valor){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
		$stmt->bind_param('s', $valor);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($_campo);
			$stmt->fetch();
			return $_campo;
		}
		else
		{
			return null;	
		}
	}
	
	function getPasswordRequest($id){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($_id);
		$stmt->fetch();
		
		if ($_id == 1)
		{
			return true;
		}
		else
		{
			return null;	
		}
	}
	
	function verificaTokenPass($user_id, $token){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
		$stmt->bind_param('is', $user_id, $token);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($activacion);
			$stmt->fetch();
			if($activacion == 1)
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
		else
		{
			return false;	
		}
	}
	
	function cambiaPassword($password, $user_id, $token){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");
		$stmt->bind_param('sis', $password, $user_id, $token);
		
		if($stmt->execute()){
			return true;
			} else {
			return false;		
		}
	}

	function MostrarProductos ($id){
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT nombre FROM productos WHERE id = ? ");
		$stmt->bind_param('i', $id);
		
		if($stmt->execute()){
			$stmt->store_result();
			$stmt->bind_result($_nombre);
			$stmt->fetch();
			return $_nombre;
		} 
	}

	function ComprarProductos ($id){
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT nombre, descripcion, md, lg, xl, 2xl, 3xl, 4xl, unitalla, precio_venta FROM productos WHERE id = ? ");
		$stmt->bind_param('i', $id);
		
		if($stmt->execute()){
			$stmt->store_result();
			$stmt->bind_result($Pnombre, $Pdescripcion, $Pmd, $Plg, $Pxl, $P2xl, $P3xl, $P4xl, $Punitalla, $Pprecio_venta);
			$stmt->fetch();
?>
			<p class="h1"><?php echo $Pnombre; ?></p>
					<div class="row mt-5">
						<div class="col">
							<p class="h2"><b><?php echo "$ " . $Pprecio_venta; ?></b></p>
						</div>
					</div>
					<form action="venta.php" class="mt-5" method="post" role="form">
						<div class="row">
							<?php if ($Punitalla == 0): ?>
								<div class="col-xs-12 col-sm-6 mt-3">	
									<p class="h3">Talla</p>
									<hr>
									<select name="talla" id="" class="custom-select form-control" required>
										<option value="nullT" selected>Selecciona una talla</option>
										<?php if ($Pmd > 0): ?>
											<option value="md">Talla M</option>
										<?php endif ?>
										<?php if ($Plg > 0): ?>
											<option value="lg">Talla L</option>
										<?php endif ?>
										<?php if ($Pxl > 0): ?>
											<option value="xl">Talla Xl</option>
										<?php endif ?>
										<?php if ($P2xl > 0): ?>
											<option value="2xl">Talla 2XL</option>
										<?php endif ?>
										<?php if ($P3xl > 0): ?>
											<option value="3xl">Talla 3XL</option>
										<?php endif ?>
										<?php if ($P4xl > 0): ?>
											<option value="4xl">Talla 4XL</option>
										<?php endif ?>
									</select>
								</div>
							<?php endif ?>
							<?php if ($Punitalla>0): ?>
								<input type="hidden" name="talla" value="unitalla">
							<?php endif ?>
							<div class="col-xs-12 col-sm-6 mt-3">
								<p class="h3">Cantidad</p>
								<hr>
								<input type="hidden" name="id" value="<?php echo $id ;?>">
								<input type="hidden" name="Pname" value="<?php echo $Pnombre ;?>">
								<input type="hidden" name="Pprecio" value="<?php echo $Pprecio_venta ;?>">
								<select name="cantidad" id="" class="custom-select form-control" required>
									<option value="nullC" selected>Selecciona la cantidad</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
							<div class="col-xs-12 col-sm-6 d-flex align-items-end mt-5 mb-0">
								<input type="submit" name="Btn_Cart" value="Agregar al carrito" class="btn btn-outline-success form-control">
							</div>
						</div>
					</form>
					<div class="row mt-5">
						<div class="col">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a href="#tab1" class="nav-link active" data-toggle="tab">Descripción</a>
								</li>
								<?php if ($Punitalla == 0): ?>
									<li class="nav-item">
										<a href="#tab2" class="nav-link" data-toggle="tab">Tallas</a>
									</li>
								<?php endif ?>
							</ul>

							<div class="tab-content">
								<div class="tab-pane active text-justify" id="tab1" role="tabpanel">
									<p class="mt-3 p-3"><?php echo $Pdescripcion; ?></p>
								</div>
								<?php if ($Punitalla == 0): ?>
									<div class="tab-pane" id="tab2" role="tabpanel">
										<figure class="figure mt-3 p-3">
						 					<?php if ($id == 2 || $id == 3 || $id == 8): ?>
						 						<img class="img-fluid" src= "img/tallas-t-shirt.jpg">
						 					<?php endif ?>
						 					<?php if ($id == 7 || $id == 15): ?>
						 						<img class="img-fluid" src= "img/tallas-shorts.jpg">
						 					<?php endif ?>
						 					<?php if ($id == 9): ?>
						 						<img class="img-fluid" src= "img/tallas-shirt.jpg">
						 					<?php endif ?>
						 					<?php if ($id == 4 || $id == 5): ?>
						 						<img class="img-fluid" src= "img/tallas-pants.jpg">
						 					<?php endif ?>
						 					<?php if ($id == 1 || $id == 6): ?>
						 						<img class="img-fluid" src= "img/tallas-hoddie.jpg">
						 					<?php endif ?>
						 				</figure>
									</div>
								<?php endif ?>
							</div>
						</div>
					</div>
		<?php } 
	}
	function registraVenta($Pid,$user,$talla,$unidades,$total){
		global $mysqli;
		$stmt = $mysqli->prepare ("INSERT INTO detalle_venta (id_producto, dni_usuario, talla, unidades_producto, fecha, total_producto, realizado) VALUES (?,?,?,?,CURDATE(),?,0)");
		$stmt->bind_param('iisii',$Pid,$user,$talla,$unidades,$total);
		$stmt->execute();	
	}
	function actualizarExistencias($unidades,$talla,$id)
	{
		global $mysqli;
		$cons = $mysqli->prepare("SELECT $talla FROM productos WHERE id = ?");
		$cons->bind_param('i',$id);
		$cons->execute();
		$cons->bind_result($existencias);
		$cons->fetch();
		if ($existencias >= $unidades) {
			$existencias = $existencias-$unidades;
		} else {
			header("Location: producto.php?id=$id&error=2&exis=$existencias");
		}
		return $existencias;
	}
	function actualizar($talla,$id,$existencias)
	{
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE productos SET $talla = ? WHERE id = ?");
		$stmt->bind_param('ii',$existencias,$id);
		$stmt->execute();
	}
	function items()
	{
		global $mysqli;
		$ui = $_SESSION["id_usuario"];
		$stmt = $mysqli->prepare("SELECT * from detalle_venta WHERE dni_usuario = $ui AND realizado = 0");
		$stmt->execute();
		$stmt->store_result();
		$items = $stmt->num_rows;
		return $items;
	}
	function carrito($Uid)
	{
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT productos.id,productos.nombre, detalle_venta.talla, detalle_venta.unidades_producto, productos.precio_venta, detalle_venta.total_producto FROM detalle_venta INNER JOIN productos ON productos.id = detalle_venta.id_producto WHERE detalle_venta.dni_usuario = ? AND detalle_venta.realizado = 0");
		$stmt->bind_param('i',$Uid);
		if ($stmt->execute()) {
			$stmt->store_result();
			$num = $stmt->num_rows;
			if ($num > 0) { $suma = 0;?>
				<div class="table-responsive">
			 		<table class="table table-striped">
					 	<thead>
						    <tr>
						      	<th scope="col" class="hidden-xs-down"></th>
						      	<th scope="col" class="text-center">Producto</th>
						      	<th scope="col" class="text-center">Talla</th>
						      	<th scope="col" class="text-center">Precio unitario</th>
						      	<th scope="col" class="text-center">Unidades</th>
						      	<th scope="col" class="text-center">Subtotal</th>
						    </tr>
						</thead>
						<tbody>
				<?php for ($i=1; $i <= $num ; $i++) { 
					$stmt->bind_result($CPid,$CPnombre,$CPtalla,$CPunidades,$CPprecio,$CPtotal);
					$stmt->fetch();
					$suma = $suma + $CPtotal;?>
							<tr>
						      	<td class="col-2 hidden-xs-down">
						      		<figure class="figure">
					 					<img class="img-fluid" src="<?php echo "img/producto".$CPid.".png"; ?>">
					 				</figure>
						      	</td>
						      	<td class="col-2 text-center td"><?php echo $CPnombre; ?></td>
						      	<td class="col-2 text-center td"><?php echo $CPtalla; ?></td>
						      	<td class="col-2 text-center td"><?php echo "$ ".$CPprecio; ?></td>
						      	<td class="col-2 text-center td"><?php echo $CPunidades; ?></td>
						      	<td class="col-2 text-center td"><?php echo "$ ".$CPtotal; ?></td>
						    </tr>
<?php 	
				}
?>
							<tr>
								<td class="col-2 hidden-xs-down"></td>
								<td class="col-2"></td>
								<td class="col-2"></td>
								<td class="col-2"></td>
								<th class="text-center td">TOTAL:</th>
								<th class="text-center td"><?php echo "$ ".$suma; ?></th>
							</tr>
						</tbody>
					</table>
					<div class="d-flex">
						<a href="compra.php?uid=<?php echo $Uid ;?>" class="btn btn-outline-success btn-lg mt-5 mb-5 mr-auto ml-auto">Realizar Pago</a>
					</div>
			 	</div>
<?php
			} else {
?>
				<div class="container">
					<div class="jumbotron mt-5 d-flex flex-column">
						<p class="display-4 mb-5">No tienes productos agregados al carrito</p>
						<a class="btn btn-outline-primary btn-lg ml-auto mr-auto mt-5" role="button" href="tienda.php">Ver productos</a>
					</div>
				</div>
<?php

			}
		}
	}
	function usuarios()
	{
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT * from usuarios WHERE id_tipo = 2");
		$stmt->execute();
		$stmt->store_result();
		$numUsuarios = $stmt->num_rows;
		return $numUsuarios;
	}
	function productos()
	{
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT * from productos");
		$stmt->execute();
		$stmt->store_result();
		$numProductos = $stmt->num_rows;
		return $numProductos;
	}
	function ingresos()
	{
		global $mysqli;
		$suma = 0;
		$stmt = $mysqli->prepare("SELECT total_producto from detalle_venta WHERE realizado = 1");
		$stmt->execute();
		$stmt->store_result();
		$numVentas = $stmt->num_rows;
		for ($i=0; $i < $numVentas; $i++) { 
			$stmt->bind_result($totalPV);
			$stmt->fetch();
			$suma = $suma + $totalPV;
		}
		return $suma;
	}
	function consultaUsuarios()
	{
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT usuarios.id, usuarios.nombres, usuarios.paterno, usuarios.materno, usuarios.direccion, usuarios.correo, tipo_usuario.tipo FROM usuarios INNER JOIN tipo_usuario ON tipo_usuario.id = usuarios.id_tipo");
		$stmt->execute();
		$stmt->store_result();
		$numUsuarios = $stmt->num_rows;?>
		<div class="table-responsive mt-3">
	 		<table class="table table-striped">
			 	<thead>
				    <tr>
				      	<th scope="col" class="text-center">Nombre(s)</th>
				      	<th scope="col" class="text-center">Paterno</th>
				      	<th scope="col" class="text-center">Materno</th>
				      	<th scope="col" class="text-center">Dirección</th>
				      	<th scope="col" class="text-center">Correo</th>
				      	<th scope="col" class="text-center">Tipo</th>
				      	<th scope="col" class="text-center"></th>
				    </tr>
				</thead>
				<tbody>
		<?php for ($i=0; $i < $numUsuarios; $i++) {
			$stmt->bind_result($id,$nombres,$paterno,$materno,$direccion,$correo,$tipo);
			$stmt->fetch();?>
					<tr>
				      	<td class="col-2 text-center td"><?php echo $nombres; ?></td>
				      	<td class="col-1 text-center td"><?php echo $paterno; ?></td>
				      	<td class="col-1 text-center td"><?php echo $materno; ?></td>
				      	<td class="col-4 text-center td"><?php echo $direccion; ?></td>
				      	<td class="col-2 text-center td"><?php echo $correo; ?></td>
				      	<td class="col-1 text-center td"><?php echo $tipo; ?></td>
				      	<td class="col-1 text-center td"><a href="<?php echo "dashboard-editar.php?id_usuario=".$id ?>" class="icon icon-pencil btn btn-outline-primary"></a></td>
				    </tr>
<?php
		}
		?>
				</tbody>
			</table>
		</div>
<?php
	}

	function consultaProductos()
	{
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT id,nombre,md,lg,xl,2xl,3xl,4xl,unitalla,precio_costo,precio_venta FROM productos");
		$stmt->execute();
		$stmt->store_result();
		$numProductos = $stmt->num_rows;?>
		<div class="table-responsive mt-3">
	 		<table class="table table-striped">
			 	<thead>
				    <tr>
				      	<th scope="col" class="text-center">Nombre</th>
				      	<th scope="col" class="text-center">MD</th>
				      	<th scope="col" class="text-center">LG</th>
				      	<th scope="col" class="text-center">XL</th>
				      	<th scope="col" class="text-center">2XL</th>
				      	<th scope="col" class="text-center">3XL</th>
				      	<th scope="col" class="text-center">4XL</th>
				      	<th scope="col" class="text-center">Unitalla</th>
				      	<th scope="col" class="text-center">Costo</th>
				      	<th scope="col" class="text-center">Venta</th>
				      	<th scope="col" class="text-center"></th>
				    </tr>
				</thead>
				<tbody>
		<?php for ($i=0; $i < $numProductos; $i++) {
			$stmt->bind_result($id,$nombre,$md,$lg,$xl,$dxl,$txl,$cxl,$unitalla,$precio_costo,$precio_venta);
			$stmt->fetch();?>
					<tr>
				      	<td class="col-2 text-center td"><?php echo $nombre; ?></td>
				      	<td class="col-1 text-center td"><?php echo $md; ?></td>
				      	<td class="col-1 text-center td"><?php echo $lg; ?></td>
				      	<td class="col-1 text-center td"><?php echo $xl; ?></td>
				      	<td class="col-1 text-center td"><?php echo $dxl; ?></td>
				      	<td class="col-1 text-center td"><?php echo $txl; ?></td>
				      	<td class="col-1 text-center td"><?php echo $cxl; ?></td>
				      	<td class="col-1 text-center td"><?php echo $unitalla; ?></td>
				      	<td class="col-1 text-center td"><?php echo $precio_costo; ?></td>
				      	<td class="col-1 text-center td"><?php echo $precio_venta; ?></td>
				      	<td class="col-1 text-center td"><a href="<?php echo "dashboard-editar.php?id_producto=".$id ?>" class="icon icon-pencil btn btn-outline-primary"></a></td>
				    </tr>
<?php
		}
		?>
				</tbody>
			</table>
		</div>
<?php
	}

	function consultaVenta()
	{
		global $mysqli;
		$stmt = $mysqli->prepare("SELECT usuarios.nombres,usuarios.paterno, productos.nombre, detalle_venta.talla, detalle_venta.unidades_producto, productos.precio_venta, detalle_venta.total_producto,detalle_venta.fecha FROM detalle_venta INNER JOIN productos ON productos.id = detalle_venta.id_producto INNER JOIN usuarios ON usuarios.id = detalle_venta.dni_usuario");
		$stmt->execute();
		$stmt->store_result();
		$numUsuarios = $stmt->num_rows;?>
		<div class="table-responsive mt-3">
	 		<table class="table table-striped">
			 	<thead>
				    <tr>
				      	<th scope="col" class="text-center">Nombre(s)</th>
				      	<th scope="col" class="text-center">Paterno</th>
				      	<th scope="col" class="text-center">Producto</th>
				      	<th scope="col" class="text-center">Talla</th>
				      	<th scope="col" class="text-center">Unidades</th>
				      	<th scope="col" class="text-center">Precio</th>
				      	<th scope="col" class="text-center">Total</th>
				      	<th scope="col" class="text-center">Fecha</th>
				    </tr>
				</thead>
				<tbody>
		<?php for ($i=0; $i < $numUsuarios; $i++) {
			$stmt->bind_result($nombre,$Paterno,$Producto,$Talla,$Unidades,$Precio,$Total,$Fecha);
			$stmt->fetch();?>
					<tr>
				      	<td class="col-2 text-center td"><?php echo $nombre; ?></td>
				      	<td class="col-1 text-center td"><?php echo $Paterno; ?></td>
				      	<td class="col-4 text-center td"><?php echo $Producto; ?></td>
				      	<td class="col-1 text-center td"><?php echo $Talla; ?></td>
				      	<td class="col-1 text-center td"><?php echo $Unidades; ?></td>
				      	<td class="col-1 text-center td"><?php echo $Precio; ?></td>
				      	<td class="col-1 text-center td"><?php echo $Total; ?></td>
				      	<td class="col-1 text-center td"><?php echo $Fecha; ?></td>
				    </tr>
<?php
		}
		?>
				</tbody>
			</table>
		</div>
<?php
	}
?>