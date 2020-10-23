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

    $query = "SELECT puertos.puid,puertos.nombre, ciudades.nombre FROM puertos, ciudades WHERE puertos.puid = $puid AND ciudades.cid = puertos.cid;"; // 


    
    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();  // Resultados de buques

    $nombre = $resultados[0][1];
    $ciudad = $resultados[0][2];
    $_SESSION['puid'] = $puid;

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
<div class="container">
    <div class="card">
        <div class="card-title"><h3>Capacidad agotada</h3></div>
        <form action="capacidad_agotada.php" method="POST">
            <input class="redondeado" type="date" name="fecha_entrada" required>
            <br><br>
            <input class="redondeado" type="date" name="fecha_salida" required>
            <br><br>
            <button class="myButton" type="submit">Buscar</button>
        </form>
    </div>
</div>