<?php
@session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>

<?php
    require("../config/conexion.php");

    $nombre = $_SESSION['username'];
    $query = "SELECT nombre, n_pasaporte, edad, nacionalidad, sexo, tipo FROM usuarios WHERE LOWER(nombre) = LOWER('$nombre');";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultado = $result -> fetchAll();
    
    $pasaporte = $resultado[0][1];
    $_SESSION['n_pasaporte'] = $pasaporte;
    $_SESSION['username'] = $resultado[0][0];
?>

<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title"><h1><?=$resultado[0][0]?></h1></div>
            <div class="row">
                <div class="col-3">
                    <span>
                        <img src="../images/perfil.jpg" alt="AVATAR" height=250px>
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
                    <?php
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
                    <form action="pdi.php" method="post">    
                        <button class="myButton" type="submit" value="PDI">
                        PDI
                        </button>
                    </form>
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
</div>
