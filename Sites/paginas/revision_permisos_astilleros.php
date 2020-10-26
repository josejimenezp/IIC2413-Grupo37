<?php
session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}

$fecha_entrada = $_POST['fecha_astillero_entrada'];
$fecha_salida = $_POST['fecha_astillero_salida'];

$_SESSION['fecha_astillero_entrada'] = $fecha_entrada;
$_SESSION['fecha_astillero_salida'] = $fecha_salida;
$patente = $_POST['patente'];
$_SESSION['patente'] = $patente;

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

$query_instalaciones = "SELECT iid,tipo, capacidad FROM instalaciones, puertos WHERE puertos.puid = instalaciones.puid AND instalaciones.puid = $puid AND instalaciones.tipo = 'astillero';";
$result = $db_puertos -> prepare($query_instalaciones);
$result -> execute();
$instalaciones = $result -> fetchAll();

foreach ($instalaciones as $instalacion){
    $iid = $instalacion[0];
    $tipo = $instalacion[1];
    $capacidad = $instalacion[2];

    $query_entrada = "SELECT capacidad_agotada('$fecha_entrada','$fecha_entrada',$iid);";
    $result_entrada = $db_puertos -> prepare($query_entrada);
    $result_entrada -> execute();
    $resultados_entrada = $result_entrada -> fetchAll();

    $query_salida = "SELECT capacidad_agotada('$fecha_salida','$fecha_salida',$iid);";
    $resultados_salida = $db_puertos -> prepare($query_salida);
    $resultados_salida -> execute();
    $resultados_salida = $resultados_salida -> fetchAll();

    if (!empty($resultados_entrada) && !empty($resultados_salida)) {?>
        <div class='card'>
        Instalación: N°<?= $iid?><br>
        Tipo: <?= $tipo?><br>
        <form action="reserva_astilleros.php" method ="GET">
            <input type="hidden" name="iid" value=<?= $iid?>>
            <button class="myButton" type="submit" value="Cambiar contraseña">
                Reservar
            </button>
        </form>
        </div>
    <?php }}
?>