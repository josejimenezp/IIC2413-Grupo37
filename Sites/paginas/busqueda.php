<?php
session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>

<?php
    require("../config/conexion.php");
    $busqueda = $_POST["busqueda"];

    // Navieras
    $query = "SELECT nid, nombre, pais, descripcion FROM navieras WHERE LOWER(navieras.nombre) LIKE LOWER('%$busqueda%');"; // nid, nombre, pais, descripcion

    $result = $db_buques -> prepare($query);
    $result -> execute();
    $navieras = $result -> fetchAll();
    
    // Puertos
    $query = "SELECT puertos.puid, puertos.nombre, ciudades.nombre FROM puertos, ciudades WHERE ciudades.cid = puertos.cid
    AND LOWER(puertos.nombre) LIKE LOWER('%$busqueda%');";

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $puertos = $result -> fetchAll();
?>

<body>        
    <br>
    <div class="container">
        <div><a type="button" class="btn" href="navieras.php"><i class="fa fa-angle-left"></i>&nbsp;Volver</a></div>
        <br>
        <h4>Resultados para "<?= $busqueda?>"</h4>
        <br>
        <h2>Navieras</h2>
        <br>
        <?php if (empty($navieras))
        {
            echo "<h4> No hay resultados </h4> <br>";
        }
        ?>
        <?php foreach ($navieras as $resultado): ?>
            <?php echo "<a href='vista_naviera.php?nid=$resultado[0]'>"; ?>
                <div class='card'>
                    <div class='card-body'>
                        <div class='card-title'>
                            <h3 > <?=$resultado[1]?> </h3>
                        </div>
                        <div class='card-text'>
                            <p> <?=$resultado[3]?> </p>
                        </div>
                    </div>
                </div>
            </a>
            <br>
        <?php endforeach; ?>
        <br>

        <h2>Puertos</h2>
        <br>
        <?php if (empty($puertos))
        {
            echo "<h4> No hay resultados </h4> <br>";
        }
        ?>
        <?php foreach ($puertos as $resultado): ?>
        <?php echo "<a href='vista_puertos.php?puid=$resultado[0]'>"; ?>
        <div class='card'>
            <div class='card-body'>
                <div class='card-title'>
                    <h3 > <?=$resultado[1]?> </h3>
                </div>
                <div class='card-text'>
                    <p> <?=$resultado[2]?> </p>
                </div>
            </div>
        </div>
        </a>
        <br>
        <?php endforeach; ?>
        <br>
    </div>
</body>
