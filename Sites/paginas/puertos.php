<?php
session_start();
if (isset($_SESSION['nombre'])) {
    require("header_user.php");
} else {
    require("../index.php");
}
?>

<?php
    require("../config/conexion.php");

    $query = "SELECT puertos.puid, puertos.nombre, ciudades.nombre FROM puertos, ciudades WHERE ciudades.cid = puertos.cid;"; 

    $result = $db_puertos -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();
?>

<body>        
    <br><br>
    <div class="container">
        <h2>Puertos</h2>
        <br>
        <?php foreach ($resultados as $resultado): ?>
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
