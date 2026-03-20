<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "RUN_AND_EAT";

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8");

?> 