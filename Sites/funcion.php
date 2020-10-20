<?php
function funcion(){require("./config/conexion.php");
$consulta_puertos = "select nombre, edad, sexo, rut from personal, instalaciones where instalaciones.jefe_id = personal.rut and personal.iid = instalaciones.iid;";
$consulta_buques = "SELECT personas.nombre, edad, genero, pasaporte, nacionalidad FROM personas, buques WHERE buques.id_capitan = personas.pid and personas.buque = buques.bid;";
$resultado_puertos = $db_puertos -> prepare($consulta_puertos);
$resultado_puertos -> execute();
$jefes = $resultado_puertos -> fetchAll();

$resultado_buques = $db_buques -> prepare($consulta_buques);
$resultado_buques -> execute();
$capitanes = $resultado_buques -> fetchAll();
foreach($jefes as $jefe){$contraseña = generatePassword();
    $nombre = $jefe[0];
    $edad = $jefe[1];
    $sexo = $jefe[2];
    $pasaporte = $jefe[3];
    $nacionalidad = 'CHILENA';
    $agregar = "INSERT INTO usuarios VALUES (:nombre,$edad,'$sexo','$pasaporte','Jefe','$nacionalidad','$contraseña');";
        $resultado = $db_puertos -> prepare($agregar);
        $resultado -> execute(['nombre'=>$nombre]);
        $resultados = $resultado -> fetchAll();
}

foreach($capitanes as $capitan){$contraseña = generatePassword();
    $nombre = $capitan[0];
    $edad = $capitan[1];
    $sexo = $capitan[2];
    $pasaporte = $capitan[3];
    $nacionalidad = $capitan[4];
    $agregar = "INSERT INTO usuarios VALUES (:nombre,$edad,'$sexo','$pasaporte','Capitan','$nacionalidad','$contraseña');";
        $resultado = $db_puertos -> prepare($agregar);
        $resultado -> execute(['nombre'=>$nombre]);
        $resultados = $resultado -> fetchAll();
}
}

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= substr($chars, $index, 1);
    }

    return $result;
}
?>