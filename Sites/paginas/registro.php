<?php
    require("../config/conexion.php");

    // Verificar si usamos username o nombre o ambos
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $nacionalidad = $_POST['nacionalidad'];
    $pasaporte = $_POST['n_pasaporte'];
    $password = $_POST['password'];
    $tipo = 'usuario_normal';

#Consultaremos si es que existe el pasaporte en la base de datos
    $consulta = "SELECT * FROM usuarios WHERE usuarios.n_pasaporte = '$pasaporte';";
    $resultado_consulta = $db_puertos -> prepare($consulta);
    $resultado_consulta -> execute();
    $resultados = $resultado_consulta -> fetchAll();
#Si existe emitiremos un error, si no existe lo agregaremos
    if (empty($resultados)){
    
        $agregar = "INSERT INTO usuarios VALUES ('$nombre',$edad,'$sexo','$pasaporte','$tipo','$nacionalidad','$password');";
        $resultado = $db_puertos -> prepare($agregar);
        $resultado -> execute();
        $resultados = $resultado -> fetchAll();
        echo "<script>alert('Registro exitoso');
        window.location.href='../index.php'</script>";
    }
    else{
        echo "<script>alert('Usuario ya existente');
        window.location.href='vista_registro.php'</script>";
    }
?>
