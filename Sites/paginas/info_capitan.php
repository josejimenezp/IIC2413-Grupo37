<?php
    $nombre = $_SESSION['username'];
    $query = "SELECT nombre, n_pasaporte, edad, nacionalidad, sexo, tipo FROM usuarios WHERE nombre = '$nombre';";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultado = $result -> fetchAll();

    $pasaporte = $resultado[0][1];

    $query = "SELECT buques.bid, buques.patente, buques.nombre, buques.tipo, buques.naviera, navieras.nombre FROM personas, buques, navieras 
    WHERE personas.pasaporte = '$pasaporte' AND buques.id_capitan = personas.pid AND navieras.nid = buques.naviera;";

    $result = $db_buques -> prepare($query);
    $result -> execute();
    $buque = $result -> fetchAll();
    $buque_id = $buque[0][0];

    $query = "SELECT fecha, id_puerto FROM proximo_itinerario WHERE proximo_itinerario.buque = $buque_id;";

    $result = $db_buques -> prepare($query);
    $result -> execute();
    $itinerario = $result -> fetchAll();

    $query = "SELECT DISTINCT fecha_atraque, id_puerto FROM atraques WHERE atraques.buque = $buque_id ORDER BY fecha_atraque DESC LIMIT 5;";

    $result = $db_buques -> prepare($query);
    $result -> execute();
    $atraques = $result -> fetchAll();
?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Buque</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Atraques</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card">
            <div class="card-body">
                <h2><?=$buque[0][2]?></h2>
                <br>
                <h5> Patente</h5>
                <p><?=$buque[0][1]?></p>
                <br>
                <h5>Tipo</h5>
                <p><?=$buque[0][3]?></p>
                <br>
                <h5>Naviera</h5>
                <p><?=$buque[0][5]?></p>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="card">
            <div class="card-body">
                <h5>Últimos atraques</h5>
                    <br>
                    <table class="table">
                        <tbody>
                            <?php foreach ($atraques as $atraque): ?>
                                <tr>
                                <td style="width: 20%"><p><?=$atraque[0]?></p></td>
                                <td><p><?=$atraque[1]?></p></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                <h5>Próximo itinerario</h5>
                <br>
                <table class="table">
                    <tbody>
                        <tr>
                        <td style="width: 20%"><p><?=$itinerario[0][0]?></p></td>
                        <td><p><?=$itinerario[0][1]?></p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>
