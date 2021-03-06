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

    $query = "SELECT * FROM navieras;"; // nid, nombre, pais, descripcion

    $result = $db_buques -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();
?>

<body>
    <br><br>
    <div class="container">
        <h2>Navieras</h2>
        <br>
        <div class="container">
            <form action="busqueda.php" method="post">
                <div class="row">
                    <div class="col-11 wrap-input100 validate-input m-b-50">
                        <input class="input100" type="nombre_nav" name="busqueda">
                        <span class="focus-input100" data-placeholder="Buscar"></span>
                    </div>
                    <div class="col-1 mt-2">
                    <button type="submit" style="vertical-align:middle;"><i class="fas fa-search fs-30"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <?php foreach ($resultados as $resultado): ?>
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
    </div>
</body>