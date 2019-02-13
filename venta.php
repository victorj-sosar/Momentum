<?php
	session_start();
	require 'funcs/funciones.php';
	require 'funcs/conexion.php';
	if (isset($_POST["Btn_Cart"])) {
		$Pid = $_POST["id"];
		if(isset($_SESSION["log_name"])){ //Si no ha iniciado sesión redirecciona a index.php
			$Pname = $_POST["Pname"];
			$talla = $_POST["talla"];
			$Pprecio = $_POST["Pprecio"];
			$unidades = $_POST["cantidad"];
			$user = $_SESSION["id_usuario"];
			$total = $unidades * $Pprecio;
			if ($talla == "nullT" || $unidades == "nullC") {
				header("Location: producto.php?id=$Pid&error=3");
			} else {
				registraVenta($Pid,$user,$talla,$unidades,$total);
				$existenciasp = actualizarExistencias($unidades,$talla,$Pid);
				actualizar($talla,$Pid,$existenciasp);
				header("Location: carrito.php");
			}
		} else {
			header("Location: producto.php?id=$Pid&error=1");
		}
	}
	else {
		header("Location: tienda.php");
	} 
?>