<?php
require("../config/conexion.php");
session_start();
$username = $_POST["username"];
$password = $_POST["password"];
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
 
// Busco si está en la tabla de usuarios
$consulta = "SELECT * FROM usuarios WHERE LOWER(usuarios.nombre) = LOWER('$username') AND usuarios.contraseña = '$password';";
$result = $db_puertos -> prepare($consulta);
$result -> execute();
$resultado = $result-> fetchAll();

// Error al iniciar sesión
if (empty($resultado)) {
    $_SESSION['password'] = 'error';
    echo "<script>alert('Credenciales inválidas');
    window.location.href='../index.php'</script>";
}
else {
    $PUID = $resultado[0][7];
    $_SESSION['postgres_uid'] = $PUID;

    // Se realiza una request a la API para obtener su id en mongodb

    // Nombre y edad del usuario
    $data = array('nombre' => $resultado[0][0], 'edad' => $resultado[0][1]);

    $options = array(
        'http' => array(
            'method' => 'GET',
            'content' => json_encode($data),
            'header' => "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
        )
    );

    $context = stream_context_create( $options );
    $result = file_get_contents( 'https://young-ocean-30844.herokuapp.com/_info-users', false, $context );
    $response = json_decode($result, true);

    // Creamos una variable de entorno con el uid en mongodb que coincide con el primer usuario que retorne
    $_SESSION['mongo_uid'] = $response[0]['uid'];

    header("location: ../paginas/perfil.php");
};

?>