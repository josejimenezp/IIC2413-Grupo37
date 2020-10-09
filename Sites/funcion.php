<?php
function funcion(){require("./config/conexion.php");
$consulta = 'select nombre, edad, sexo, rut from personal, instalaciones where instalaciones.jefe_id = personal.rut and personal.iid = instalaciones.iid;';
$consulta2 = pg_query($consulta);
$resultado = $db -> prepare($consulta);
$resultado -> execute();
$jefes = $resultado -> fetchAll();
$largo = pg_num_rows($consulta2);
for($i=1;$i<=$largo;$i++){$contraseña = generatePassword();
    $nombre = $jefes[$i][0];
    $edad = $jefes[$i][1];
    $sexo = $jefes[$i][2];
    $pasaporte = $jefes[$i][3];
    $nacionalidad = 'chilena';
    $agregar = "INSERT INTO usuarios VALUES ('$nombre',$edad,'$sexo','$pasaporte','$nacionalidad','$password');";
        $resultado = $db -> prepare($agregar);
        $resultado -> execute();
        $resultados = $resultado -> fetchAll();
}
}

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}
?>