<?php
session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}

$fecha = $_POST['fecha_muelle'];
$patente = $_POST['patente'];

require("../config/conexion.php");

$puid = $_SESSION["puid"];

$query = "SELECT puertos.puid,puertos.nombre, ciudades.nombre FROM puertos, ciudades WHERE puertos.puid = $puid AND ciudades.cid = puertos.cid;"; 



$result = $db_puertos -> prepare($query);
$result -> execute();
$resultados = $result -> fetchAll();  // Resultados de buques

$nombre = $resultados[0][1];
$ciudad = $resultados[0][2];
$_SESSION['nombre_puerto'] = $nombre;

    
    ?>
<br>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title"><h1><?=$nombre?></h1></div>
            <div class="row">
                <div class="col-3">
                    <span>
						<img src="../images/puerto.jpg" alt="AVATAR" height=250px>
					</span>
                </div>
                <div class="col-9">
                    <h5>Información</h5>
                    <br>
                    <ul class="list-inline">
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-map-marker"></i>&nbsp;&nbsp;<?= $ciudad?></li>
                </div>
            </div>
        </div>
    </div>
<br><br>

<?php 

$query_instalaciones = "SELECT iid,tipo, capacidad FROM instalaciones, puertos WHERE puertos.puid = instalaciones.puid AND instalaciones.puid = $puid AND instalaciones.tipo = 'muelle;";
$result = $db_puertos -> prepare($query_instalaciones);
$result -> execute();
$instalaciones = $result -> fetchAll();

foreach ($instalaciones as $instalacion){
    $iid = $instalacion[0];
    $tipo = $instalacion[1];
    $capacidad = $instalacion[2];

    $query = "SELECT capacidad_agotada('$fecha','$fecha',$iid);";
    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();

    if (!empty($resultados)){?>
        <div class='card'>
        Instalación: N°<?= $iid?><br>
        Tipo: <?= $tipo?><br>
        </div>
    <?php }}
?>