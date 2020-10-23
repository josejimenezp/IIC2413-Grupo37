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
                    <ul class="list-inline">
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-map-marker"></i>&nbsp;&nbsp;<?= $pais?></li>
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-check"></i>&nbsp;&nbsp;<?= $descrip?></li>
                    </ul>

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
    $resultados_porcentaje = $resultados_porcentaje -> fetchAll();

    foreach ($resultados as $resultado){ ?>
        <div class='card'>
        <br>
        <h6>   Fecha: <?=$resultado[0]?></h6>
        <br>
        </div>
    <?php }
    
} ?>
    
} ?>