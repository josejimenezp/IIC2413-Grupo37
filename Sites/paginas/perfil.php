<?php
@session_start();
if (isset($_SESSION['nombre'])) { // No se si esta bien
    require("header_user.php");
} else {
    header("location: ./home.php");
}
?>

<?php

    
    require("../config/conexion.php");

    $nombre = $_SESSION['nombre'];
    $query = "SELECT nombre, n_pasaporte, edad, nacionalidad, sexo, tipo FROM usuarios WHERE nombre = '$nombre';";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultado = $result -> fetchAll();
    
    $pasaporte = $resultado[0][1];
    $_SESSION['n_pasaporte'] = $pasaporte;
?>



<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title"><h1><?=$_SESSION['nombre']?></h1></div>
            <div class="row">
                <div class="col-3">
                    <span>
						<img src="images/perfil.jpg" alt="AVATAR">
					</span>
                </div>
                <div class="col-9">
                    <h5>Información</h5>
                    <br>
                    <ul class="list-inline">
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-birthday-cake"></i>&nbsp;&nbsp;<?= $resultado[0][2] . " años"?></li>
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-address-card"></i>&nbsp;&nbsp;<?= $resultado[0][1]?></li>
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-map-marker"></i>&nbsp;&nbsp;<?= $resultado[0][3]?></li>
                        <li class="list-group-item" style="display: inline-block;"><?= $resultado[0][4]?></li>
                    </ul>

                    <br>
                    <?php // Hay que cambiar ese 1 por 5
                    if ($resultado[0][5] == 'Capitan') {
                        echo '<h5>Labor</h5>';
                        echo '<p> Capitan </p>';
                    }
                    else if ($resultado[0][5] == 'Jefe') {
                        echo '<h5>Labor</h5>';
                        echo '<p> Jefe de instalación</p>';
                    };
                    ?>
                <br>
                <form action="cambio_contrasena.php" method="post">    
                <button class="myButton" type="submit" value="Cambiar contraseña">
							Cambiar contraseña
						</button>
                </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
    if ($resultado[0][5] == 'Capitan') {
        require('info_capitan.php');
    }
    else if ($resultado[0][5] == 'Jefe') {
        require('info_jefe.php');
    };
    ?>