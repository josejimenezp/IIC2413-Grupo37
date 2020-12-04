<?php
session_start();
require("../config/conexion.php");
$query_cantidad = "SELECT MAX(permisos.pid) FROM permisos;";

$id_max = $db_puertos -> prepare($query_cantidad);
$id_max -> execute();
$id_max = $id_max -> fetchAll();

$id_max = $id_max[0][0];

$pid = $id_max + 1;
$iid = $_GET['iid'];
$patente = $_SESSION['patente'];
$fecha_atraque = $_SESSION['fecha_astillero_entrada'];
$fecha_salida = $_SESSION['fecha_astillero_salida'];

$query_insert = "INSERT INTO permisos VALUES ($pid, $iid, '$patente', '$fecha_atraque');";
$insert = $db_puertos -> prepare($query_insert);
$insert -> execute();
$insert = $insert -> fetchAll();

$query_insert = "INSERT INTO permisos_astilleros VALUES ($pid,'$fecha_salida');";
$insert = $db_puertos -> prepare($query_insert);
$insert -> execute();
$insert = $insert -> fetchAll();
echo "<script>alert('Reserva existosa');
    window.location.href='perfil.php'</script>";
?>