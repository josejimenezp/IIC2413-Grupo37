<?php
session_start();
require("header_user.php");
require("../config/conexion.php");

$fecha_entrada = $_POST["fecha_entrada"];
$fecha_salida = $_POST["fecha_salida"];

$query = "SELECT capacidad_agotada('$fecha_entrada','$fecha_salida',1);"; // FALTA HACER EL FOR DE AFUERA
$porcentaje = "SELECT porcentaje_prom();";

$result = $db_puertos -> prepare($query);
$result -> execute();
$resultados = $result -> fetchAll();

$resultados_porcentaje = $db_puertos -> prepare($porcentaje);
$resultados_porcentaje -> execute();
$resultados_porcentaje = $resultados_porcentaje -> fetchAll()?>;
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
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-map-marker"></i>&nbsp;&nbsp;<?= $pais?></li>
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-check"></i>&nbsp;&nbsp;<?= $descrip?></li>
                    </ul>

                    <br>
                    <h5>Ocupacion promedio<?=$resultados_porcentaje[0]?></h5>
                    <br>
                </div>
            </div>
        </div>
    </div>

<?php foreach ($resultados as $resultado):
    ?>
<div class='card'>
    <p>Fecha: <?=$resultado[0]?></p>
</div>
<?php endforeach; ?>



