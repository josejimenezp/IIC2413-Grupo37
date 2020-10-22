<?php
session_start();
if (isset($_SESSION['nombre'])) {
    require("header_user.php");
} else {
    require("header.php");
}
    require("../config/conexion.php");
    $fecha_entrada = $_POST["fecha_entrada"]
    $fecha_salida = $_POST["fecha_salida"]

    $query = "SELECT capacidad_agotada('$fecha_entrada','$fecha_salida',1);"; // 
    
    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();  // Resultados de buques

    echo $resultados

    ?>