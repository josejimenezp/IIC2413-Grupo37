<?php
session_start();
if (isset($_SESSION['username'])) { // No se si esta bien
    require("header_user.php");
} else {
    header("location: home.php");
}
?>

<?php

    
    require("../config/conexion.php");

    $nombre = $_SESSION['username'];
    $query = "SELECT * FROM usuarios WHERE nombre = '$nombre';";

    // Si es capitán
    if ($_SESSION['tipo'] == 'Capitan'){
        $result_buques = $db_buques -> prepare($query);
        $result_buques -> execute();
        $resultado_buques = $result_buques -> fetchAll();
        $resultado = $result_buques;
    }
    // Si es jefe
    else if ($_SESSION['tipo'] == 'Jefe') {
        $result_puertos = $db_puertos -> prepare($query);
        $result_puertos -> execute();
        $resultado_puertos = $result_puertos -> fetchAll();
        $resultado = $resultado_puertos;
    }
    else {
        header("location: home.php");
    };
?>


<script>
  console.log(<?= $resultado[0][0] ?>)
</script>



<br>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title"><h1><?=$_SESSION['username']?></h1></div>
            <div class="row">
                <div class="col-3">
                    <div class="card" style="background: lightgrey; height: 250px"></div>
                </div>
                <div class="col-9">
                    <h5>Información</h5>
                    <br>
                    <ul class="list-inline">
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-birthday-cake"></i>&nbsp;&nbsp;<?= $resultado[0][1] . " años"?></li>
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-address-card"></i>&nbsp;&nbsp;<?= $resultado[0][3]?></li>
                        <li class="list-group-item" style="display: inline-block;"><i class="fas fa-map-marker"></i>&nbsp;&nbsp;<?= $resultado[0][4]?></li>
                        <li class="list-group-item" style="display: inline-block;"><?= $resultado[0][2]?></li>
                    </ul>

                    <br>
                    <h5>Otras cosas</h5>
                    <br>
                    <p>...</p>
                </div>
            </div>
        </div>
    </div>

</div>