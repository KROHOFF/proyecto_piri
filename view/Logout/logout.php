<?php
require_once("../../config/conexion.php");
$conexion = new Conectar(); // Crear una instancia de la clase Conectar
session_destroy();
header("Location:" . $conexion->ruta() . "/../index.php"); // Llamar al método en la instancia
exit();
?>