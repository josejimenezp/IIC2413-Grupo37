<?php
require("../config/conexion.php");
@session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
    integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
    crossorigin=""></script>

    <head>
    <meta charset='utf-8'>
    <title>Tarea grande parte 2.1</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
    integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
    crossorigin=""/>
</head>
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



curl_setopt ($curl, CURLOPT_URL, "http://young-ocean-30844.herokuapp.com/messages/user?name=Garin Hills");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec ($curl);

$data = json_decode(trim($result), TRUE);

?>
<body>
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
    integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
    crossorigin=""></script>
    <div id="mapid" style="height: 600px">

        <script> 
            var mymap = L.map('mapid').setView([-33.499572, -70.615472], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);
            <?php foreach ($data as $punto) {
                $long = $punto['long'];
                $lat  = $punto['lat'];
                echo 'L.marker(['. $lat . ', ' . $long . ']).addTo(mymap);'; 
            } ?>
        </script>
    </div>
</script>
<?php
if ($tipo == 'Capitan') {
    $obtener_rut = "SELECT n_pasaporte, nombre FROM usuarios WHERE usuarios.uid = $id_usuario;";
    $result = $db_puertos -> prepare($obtener_rut);
    $result -> execute();
    $resultado = $result-> fetchAll();
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

    foreach ($resultado as $resultado) {
        echo $resultado[0];
    }
}

elseif ($tipo == 'Jefe') {
    $obtener_rut = "SELECT n_pasaporte FROM usuarios WHERE usuarios.uid = $id_usuario;";
    $result = $db_puertos -> prepare($obtener_rut);
    $result -> execute();
    $resultado = $result-> fetchAll();
    
    $pasaporte = $resultado[0][0];
    $es_jefe = "SELECT puertos.nombre FROM usuarios, instalaciones, puertos WHERE usuarios.n_pasaporte = instalaciones.jefe_id AND instalaciones.puid = puertos.puid AND usuarios.n_pasaporte = '$pasaporte';";
    $result = $db_puertos -> prepare($es_jefe);
    $result -> execute();
    $resultado = $result-> fetchAll();

    $puertos = $resultado[0][0];
    echo $puertos;
};

?>