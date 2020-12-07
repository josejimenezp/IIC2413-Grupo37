<?php
require("../config/conexion.php");
@session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>
<?php
$curl = curl_init();
$id_usuario = $_POST['id'];
$fecha_1 = $_POST['fecha1'];
$fecha_2 = $_POST['fecha2'];
$palabras_clave = $_POST['palabras_clave'];

$query = "SELECT tipo FROM usuarios WHERE usuarios.uid = $id_usuario;";
$result = $db_puertos -> prepare($query);
$result -> execute();
$resultado = $result-> fetchAll();
$tipo = $resultado[0][0];
$coordenadas =  new ArrayObject();

if ($tipo == 'Capitan') {
    $obtener_rut = "SELECT n_pasaporte, nombre FROM usuarios WHERE usuarios.uid = $id_usuario;";
    $result = $db_puertos -> prepare($obtener_rut);
    $result -> execute();
    $resultado = $result-> fetchAll();
    $nombre = $resultado[0][1];
    $lista_nombre = str_replace(' ', '%20', $nombre);

    $pasaporte = $resultado[0][0];
    $obtener_id = "SELECT pid FROM personas WHERE pasaporte = '$pasaporte';";
    $result = $db_buques -> prepare($obtener_id);
    $result -> execute();
    $resultado = $result-> fetchAll();
    $id_nuevo = $resultado[0][0];
    $obtener_barcos = "SELECT bid FROM buques WHERE buques.id_capitan = $id_nuevo;";
    $result = $db_buques -> prepare($obtener_barcos);
    $result -> execute();
    $resultado = $result-> fetchAll();

    $id_buque = $resultado[0][0];
    $id_puerto = "SELECT id_puerto FROM atraques WHERE atraques.buque = $id_buque AND fecha_atraque >= '$fecha_1' AND fecha_atraque <= '$fecha_2';";
    $result = $db_buques -> prepare($id_puerto);
    $result -> execute();
    $resultado = $result-> fetchAll();

    foreach ($resultado) {
        echo $resultado;
        echo "Hola";
        //$query_puerto = "SELECT latidud, longitud FROM coordenadas_puertos WHERE coordenadas_puertos.puerto = '$resultado';";
        //$result = $db_puertos -> prepare($query_puerto);
        //$result -> execute();
        //$coordenadas_puertos = $result-> fetchAll();
        //$coordenadas ->append($coordenadas_puertos);
        
    }
    //echo $coordenadas; 
}

elseif ($tipo == 'Jefe') {
    $obtener_rut = "SELECT n_pasaporte, nombre FROM usuarios WHERE usuarios.uid = $id_usuario;";
    $result = $db_puertos -> prepare($obtener_rut);
    $result -> execute();
    $resultado = $result-> fetchAll();
    
    $nombre = $resultado[0][1];
    $lista_nombre = str_replace(' ', '%20', $nombre);
    $pasaporte = $resultado[0][0];
    $es_jefe = "SELECT puertos.nombre FROM usuarios, instalaciones, puertos WHERE usuarios.n_pasaporte = instalaciones.jefe_id AND instalaciones.puid = puertos.puid AND usuarios.n_pasaporte = '$pasaporte';";
    $result = $db_puertos -> prepare($es_jefe);
    $result -> execute();
    $resultado = $result-> fetchAll();

    $puerto = $resultado[0][0];
    $query_puerto = "SELECT latidud, longitud FROM coordenadas_puertos WHERE coordenadas_puertos.puerto = '$puerto';";
    $result = $db_puertos -> prepare($query_puerto);
    $result -> execute();
    $coordenadas = $result-> fetchAll();
    
};
?>