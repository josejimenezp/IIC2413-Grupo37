<?php
require("../config/conexion.php");
session_start();
$nombre = $_POST["username"];
$password = $_POST["password"];
$_SESSION['nombre'] = $nombre;
$_SESSION['password'] = $password;
 
// Busco si está en la tabla de usuarios
$consulta = "SELECT * FROM usuarios where usuarios.nombre = '$nombre' and usuarios.contraseña = '$password';";
$result = $db_puertos -> prepare($consulta);
$result -> execute();
$resultado = $result-> fetchAll();
$usuarios = $result;

// Error al iniciar sesión
if (empty($usuarios)) {
    echo "Error en contraseña o usuario";
    $_SESSION['password'] = 'error';
    header("location: ../index.php");
    $_SESSION['tipo'] = '';
}
else {
    header("location: ../paginas/perfil.php");
};

?>