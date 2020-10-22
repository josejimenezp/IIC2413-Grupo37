<?php
session_start();
require("header_user.php");
require("../config/conexion.php");

$fecha_entrada = $_POST["fecha_entrada"];
$fecha_salida = $_POST["fecha_salida"];

$query = "SELECT capacidad_agotada('$fecha_entrada','$fecha_salida',1);"; // 

$result = $db_puertos -> prepare($query);
$result -> execute();
$resultados = $result -> fetchAll();  // Resultados de buques

foreach ($resultados as $resultado):
    ?>
<div class='card'>
    <p><?=$resultado[0]?></p>
</div>
<?php endforeach; ?>



