<?php
session_start();
require("header_user.php");
require("../config/conexion.php");

$fecha_entrada = $_POST["fecha_entrada"];
$fecha_salida = $_POST["fecha_salida"];
$puid = $_SESSION['puid'];
$nombre_puerto = $_SESSION['nombre_puerto']
$query_instalaciones = "SELECT iid,tipo, capacidad FROM instalaciones, puertos WHERE puertos.puid = instalaciones.puid AND instalaciones.puid = $puid;";
$result = $db_puertos -> prepare($query_instalaciones);
$result -> execute();
$instalaciones = $result -> fetchAll();?>

<div class="container">
    <div class="card">
        <b>Puerto <?=$nombre_puerto?></b>
    </div>
</div>

<?php 
foreach ($instalaciones as $instalacion){
    $iid = $instalacion[0];
    $tipo = $instalacion[1];
    $capacidad = $instalacion[2];

    $query = "SELECT capacidad_agotada('$fecha_entrada','$fecha_salida',$iid);";
    $porcentaje = "SELECT porcentaje_prom();";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();

    $resultados_porcentaje = $db_puertos -> prepare($porcentaje);
    $resultados_porcentaje -> execute();
    $resultados_porcentaje = $resultados_porcentaje -> fetchAll();?>

    <div class='card'>
    Instalación: N°<?= $iid?><br>
    Tipo: <?= $tipo?><br>
    Capacidad: <?= $capacidad?><br>
    </div>
    <div class='card'>
    <?php foreach ($resultados as $resultado){ ?>
        <p>   Fecha: <?=$resultado[0]?></p>
        <br>
    <?php } ?>
    </div>
    <br>
<?php    
} ?>