<?php
require("../config/conexion.php");
session_start();
$nombre = $_POST["username"];
$password = $_POST["password"];
$_SESSION['nombre'] = $nombre;
$_SESSION['password'] = $password;
 
// Busco si está en la tabla de usuarios
$consulta = "SELECT * FROM usuarios where LOWER(usuarios.nombre) = LOWER('$nombre') and usuarios.contraseña = '$password';";
$result = $db_puertos -> prepare($consulta);
$result -> execute();
$resultado = $result-> fetchAll();

// Error al iniciar sesión
if (empty($resultado)) {
    $_SESSION['password'] = 'error';
    echo "<script>alert('Credenciales inválidas');
        window.location.href='../index.php'</script>";
    //$_SESSION['tipo'] = '';
}
else {
    header("location: ../paginas/perfil.php");
};

?>