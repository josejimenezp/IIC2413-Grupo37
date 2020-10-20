
<?php
    $nombre = $_SESSION['nombre'];
    $query = "SELECT nombre, n_pasaporte, edad, nacionalidad, sexo, tipo FROM usuarios WHERE nombre = '$nombre';";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultado = $result -> fetchAll();

    $pasaporte = $resultado[0][1];

    $query = "SELECT puertos.nombre, puertos.ciudad, instalaciones.tipo FROM instalaciones, puertos
    WHERE instalaciones.puid = puertos.puid AND instalaciones.jefe_id = '$pasaporte';";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $puerto = $result -> fetchAll();

?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Puerto</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Instalación</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card">
            <div class="card-body">
                <h2><?=$puerto[0][0]?></h2>
                <br>
                <h5>Ciudad</h5>
                <p><?=$puerto[0][1]?></p>
                <br>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="card">
            <div class="card-body">
                <h2>Instalación</h2>
                <br>
                <h5>Tipo</h5>
                <p><?=$puerto[0][2]?></p>
                <br>
            </div>
        </div>
    </div>
</div>
