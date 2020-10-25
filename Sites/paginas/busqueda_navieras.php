<?php
session_start();
if (isset($_SESSION['username'])) {
    require("header_user.php");
}
else {
    header("location: ../index.php");
}

?>

<?php
    require("..\config\conexion.php");

    $query = "SELECT * FROM navieras"; // nid, nombre, pais, descripcion

    $result = $db -> prepare($query);
    $result -> execute();
    $resultados = $result -> fetchAll();

    ?>

<body>  
    <br><br>
    <div class="container">
        <h2>Navieras</h2>
    </div>

    <div class="container">
        <br>
        <form action="navieras.php" class="wrap-input100 validate-input m-b-50" method="get">
            Nombre de la naviera: <input class="input100" type="text" name="nombre_nav" value="<?php echo $nombre_nav;?>">
            <button type="submit" class="login100-form-btn">
            <span class="focus-input100" data-placeholder="Busqueda"></span>
        </form>

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

        <?php endforeach;
        ?>
        <br>
    </div>
</body>
