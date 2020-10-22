<?php
session_start();
if (isset($_SESSION['nombre'])) {
    require("header_user.php");
} else {
    require("header.php");
}
?>
<link rel="stylesheet" type="text/css" href="css/main.css">
<?php
    require("../config/conexion.php");

    $puid = $_GET["puid"];

    $query = "SELECT * FROM puertos WHERE puertos.puid = $puid;"; // 

    $query_naviera = "SELECT navieras.nombre, navieras.descripcion, paises.nombre FROM navieras, paises
    WHERE navieras.nid = $nid and paises.paid = navieras.pais LIMIT 1;";
    
    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();  // Resultados de buques

    $nombre = $resultados[0][1];
    $ciudad = $resultados[0][2];

    ?>

<br>

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
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-map-marker"></i>&nbsp;&nbsp;<?= $ciudad?></li>
                </div>
            </div>
        </div>
    </div>

<div class="container">
    <div class="card">
        <div class="card-title"><h1><?Capacidad agotada?></h1></div>
    </div>
</div>