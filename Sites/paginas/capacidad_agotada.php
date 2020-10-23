<?php
session_start();
require("header_user.php");
require("../config/conexion.php");

$fecha_entrada = $_POST["fecha_entrada"];
$fecha_salida = $_POST["fecha_salida"];
$puid = $_SESSION['puid'];
$pais = 'Chile';
$descrip = 'JAJAJAJAJ';
$query_instalaciones = "SELECT iid,tipo, capacidad FROM instalaciones, puertos WHERE puertos.puid = instalaciones.puid AND instalaciones.puid = $puid;";
$result = $db_puertos -> prepare($query_instalaciones);
$result -> execute();
$instalaciones = $result -> fetchAll();?>

<div class="container">

    <div class="card">
        <div class="card-body">
            <div class="card-title"><h1><?=$nombre?></h1></div>
            <div class="row">
                <div class="col-3">
                    <div class="card" style="background: lightgrey; height: 250px"></div>
                </div>
                <div class="col-9">
                    <h5>Información</h5>
                    <br>

                    <br>
                    <br>
                </div>
            </div>
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