<?php
require("../config/conexion.php");
session_start();
$password_nueva = $_POST["contrasena_nueva"];
$password_antigua = $_POST["contrasena_antigua"]; 
$pasaporte = $_SESSION['n_pasaporte'];
$password = $_SESSION['password'];
// Busco si está en la tabla de usuarios
if ($password_antigua == $password){
    $update = "UPDATE usuarios SET contraseña='$password_nueva' WHERE usuarios.n_pasaporte = '$pasaporte';"; 
    $result = $db_puertos -> prepare($update);
    $result -> execute();
    $resultado = $result-> fetchAll();
    echo "<script>alert('Cambio de contraseña exitoso');
    window.location.href='../paginas/perfil.php'</script>";

}
else {
    echo "<script>alert('La contraseña antigua no es correcta');
        window.location.href='../paginas/cambio_contrasena.php'</script>";
}

?>