<?php
@session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>

<body>
    <div class="row p-t-100 p-b-20">
        <div class="mx-auto p-b-20">
            <h1>Interfaz PDI</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8 m-l-100 m-r-100">
            <form action="busqueda_sospechoso.php" method="post">
                <label for='id'>ID de usuarios:</label><br>
                <br>
                <div class="input-group mb-3">
                    <div class="input-group-addon">
                        <span class="input-group-text" id="idusuarios">ID</span>
                    </div>
                    <input type='number' id='id' name='id' class="form-control" aria-label="ID" aria-describedby="idusuarios">
                </div>
                <label for='date'>Fechas:</label><br>    
                <div class="input-group mb-3">
                    <input class="form-control" type='date' id='date' name='fecha1'><bc>
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" type='date' id='date' name='fecha2'><bc>
                </div>
                <label for='palabras_clave'>Palabras clave:</label><br>
                <div class="input-group">
                    <textarea class="form-control" id='palabras_clave' name='palabras_clave' placeholder="Escribe aquí las palabras clave"></textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</body>
