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


    echo $fecha_entrada;
    echo $fecha_salida;

    ?>