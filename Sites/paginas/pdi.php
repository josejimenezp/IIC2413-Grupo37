<?php
@session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>

<form action="busqueda_sospechoso.php" method="post">
    <label for='id'>ID de usuarios:</label><br>    
    <input type='number' id='id' name='id'><br><br>
    <label for='date'>Fechas:</label><br>    
    <input type='date' id='date' name='fecha1'><bc>
    <input type='date' id='date' name='fecha2'>
    <br><br>
    <label for='palabras_clave'>Palabras clave:</label><br>
    <input type='text' id='palabras_clave' name='palabras_clave'><br><br>
    <button class="myButton" type="submit" value="Buscar">
Buscar
</button>
</form>
