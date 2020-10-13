<?php
require("../config/conexion.php");
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
 
// Busco si está en la BDD de buques y navieras
$consulta = "SELECT * FROM usuarios where usuarios.username = '$username' and usuarios.password = '$password';";
$result_buques = $db_buques -> prepare($consulta);
$result_buques -> execute();
$resultado_buques = $result_buques -> fetchAll();
$usuarios_buques = $result_buques;
$_SESSION['tipo'] = 'Capitan';

// Busco si está en la BDD de puertos
if (empty($usuarios_buques)){
    $result_puertos = $db_puertos -> prepare($consulta);
    $result_puertos -> execute();
    $resultado_puertos = $result_puertos -> fetchAll();
    $usuarios_puertos = $resultado_puertos;
    $_SESSION['tipo'] = 'Jefe';
};
// Error al iniciar sesión
if (empty($usuarios_puertos)) {
    echo "Error en contraseña o usuario";
    // $_SESSION['password'] = 'poto';
    header("location: ../index.php");
    $_SESSION['tipo'] = '';
}
else {
    echo "Iniciado correctamente";
    header("location: ../paginas/perfil.php");
};

?>