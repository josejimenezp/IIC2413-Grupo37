<?php
require("../config/conexion.php");
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
 
#Consulta
$consulta = "SELECT * FROM usuarios where usuarios.nombre = '$username' and usuarios.password= '$password';";
$resultado = $db -> prepare($consulta);
$resultado -> execute();
$usuarios = $resultado -> fetchAll();

if (empty($usuarios)){
    echo "Error en contraseña o usuario";
    $_SESSION['password'] = 'poto';
    header("location: ../index.php");
}
else {
    echo "Iniciado correctamente";
    header("location: ../paginas/perfil.php");
}

?>