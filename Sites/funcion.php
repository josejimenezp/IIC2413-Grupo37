<?php
function funcion(){require("./config/conexion.php");
$consulta = 'select nombre, edad, sexo, rut from personal, instalaciones where instalaciones.jefe_id = personal.rut and personal.iid = instalaciones.iid;';
$prueba1 = 'select * from prueba;';
$res = $db -> prepare($prueba1);
$res -> execute();
$poto = $res -> fetchAll();
$large = count($poto);
echo $large;
$resultado = $db -> prepare($consulta);
$resultado -> execute();
$jefes = $resultado -> fetchAll();
$largo = count($jefes);
echo $largo;
for($i=0;$i<=$largo;$i++){$contraseña = generatePassword();
    $nombre = $jefes[$i][0];
    $edad = $jefes[$i][1];
    $sexo = $jefes[$i][2];
    $pasaporte = $jefes[$i][3];
    $nacionalidad = 'chilena';
    $agregar = "INSERT INTO usuarios VALUES ('$nombre',$edad,'$sexo','$pasaporte','$nacionalidad','$contraseña');";
        $resultado = $db -> prepare($agregar);
        $resultado -> execute();
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