<?php
function funcion(){require("./config/conexion.php");
$consulta = 'select nombre, edad, sexo, rut from personal, instalaciones where instalaciones.jefe_id = personal.rut and personal.iid = instalaciones.iid;';
$resultado = $db -> prepare($consulta);
$resultado -> execute();
$jefes = $resultado -> fetchAll();
foreach($jefes as $jefe){$contraseña = generatePassword();
    $nombre = $jefe[0];
    $edad = $jefe[1];
    $sexo = $jefe[2];
    $pasaporte = $jefe[3];
    $nacionalidad = 'chilena';
    $agregar = "INSERT INTO usuarios VALUES (':nombre',$edad,'$sexo','$pasaporte','$nacionalidad','$contraseña');";
        $resultado = $db -> prepare($agregar);
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