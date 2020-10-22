<?php
session_start();
if (isset($_SESSION['nombre'])) {
    require("header_user.php");
} else {
    require("header.php");
}
?>

<?php
    require("../config/conexion.php");

    $puid = $_GET["puid"];

    $query = "SELECT * FROM puertos WHERE puertos.puid = $puid;"; // 

    $query_naviera = "SELECT navieras.nombre, navieras.descripcion, paises.nombre FROM navieras, paises
    WHERE navieras.nid = $nid and paises.paid = navieras.pais LIMIT 1;";
    
    $result = $db_buques -> prepare($query);
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
                    </ul>
                    <p>...</p>
                </div>
            </div>
        </div>
    </div>


    <br><br>
    <h2>Buques de <?=$nombre?><h2>
    <br>

    <?php foreach ($resultados as $resultado): ?>

    <div class='card'>
        <div class='card-body'>
            <div class='card-title'>
                <h3 > <?=$resultado[2]?> </h3>
            </div>
            <div class='card-text'>
                <p> Patente: <?=$resultado[1]?> </p>
            </div>
            <div class='card-text'>
                <p> Tipo: <?=$resultado[4]?> </p>
            </div>

        </div>
        </div>
    <br>

    <?php endforeach; ?>

<br>
</div>