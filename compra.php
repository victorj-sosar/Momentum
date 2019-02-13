<?php
require 'funcs/conexion.php';
global $mysqli;
$uid = $_GET["uid"];
$stmt = $mysqli->prepare("UPDATE detalle_venta SET realizado=1 WHERE dni_usuario = ?");
$stmt->bind_param('i', $uid);
$result = $stmt->execute();
header("Location: index.php");
?>