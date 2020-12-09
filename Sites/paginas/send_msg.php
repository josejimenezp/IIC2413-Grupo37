<?php
session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>

<?php
    require("../config/conexion.php");

    $postgres_uid = $_SESSION['postgres_uid'];
    $mongo_uid = $_SESSION['mongo_uid'];

    // Obtengo información del usuario para insertar en el mensaje
    $query_data_usuario = "SELECT * FROM usuarios WHERE uid = '$postgres_uid';";

    $result = $db_puertos -> prepare($query_data_usuario);
    $result -> execute();
    $data_usuario = $result -> fetchAll();

    // Capitan o jefe y su pasaporte
    $tipo_usuario = $data_usuario[0][4];
    $pasaporte = $data_usuario[0][3];

    // Necesitaremos la latitud y longitud del usuario que envía el mensaje

    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
        )
    );

    $context = stream_context_create( $options );
    $result = file_get_contents( "https://young-ocean-30844.herokuapp.com/users/$mongo_uid", false, $context );
    $response = json_decode($result, true);

    
?>
<?php
    if ($response == 'No existe este usuario :('){
        echo '<h1>Error, el usuario no existe en nuestra base de datos</h1>';
        $latitud = '';
        $longitud = '';
    }
    // Si no ha enviado mensajes antes
    elseif(count($response) == 1){

        // Si es Jefe de puerto
        if ($tipo_usuario == 'Jefe'){
            // Obtenemos las coordenadas del puerto
            $query_coor_puerto = "SELECT usuarios.n_pasaporte, puertos.nombre, coordenadas_puertos.latitud, 
            coordenadas_puertos.longitud FROM usuarios, puertos, instalaciones, coordenadas_puertos WHERE 
            usuarios.uid = $postgres_uid AND usuarios.n_pasaporte = instalaciones.jefe_id 
            AND instalaciones.puid = puertos.puid AND puertos.nombre = coordenadas_puertos.puerto;";

            $result = $db_puertos -> prepare($query_coor_puerto);
            $result -> execute();
            $coor_puerto = $result -> fetchAll();

            // Latitud
            $latitud = $coor_puerto[0][2];

            // Longitud
            $longitud = $coor_puerto[0][3];
        }
        // Si es Capitán
        else{
            $latitud = -1*(rand(27374641, 50291406)/1000000);
            $longitud = -1*(rand(90276865, 90979990)/1000000);
        };
    }
    else{
        $latitud = $response[1]["lat"];
        $longitud = $response[1]["long"];
    };
?>
<body>
    <div class="container-login100">
        <div class="row">
            <div class="mx-auto">
                <div class="wrap-login100 p-t-85 p-b-20">
                    <div class="row ">
                        <span class="login100-form-title mx-auto" style="font-size: 40px">
                            Enviar mensaje
                        </span>
                    </div>
                    <div class="api-requester">
                        <form action="request_send_msg.php" method="get">
                            <input type="hidden" name="sender_uid" value="<?php echo $mongo_uid ?>">
                            <input type="hidden" name="latitud" value="<?php echo $latitud ?>">
                            <input type="hidden" name="longitud" value="<?php echo $longitud ?>">
                            <label for="nombre_receptant">Nombre del receptor del mensaje:</label><br>
                            <div class="wrap-input100 validate-input m-b-50" data-validate="Este campo es requerido">
                                <input id="nombre_receptant" class="input100" type="text" name="nombre_receptant">
                            </div>
                            <label for="mensaje">Mensaje:</label><br>
                            <div class="wrap-input100 validate-input m-b-50" data-validate="Este campo es requerido">
                                <textarea id="mensaje" class="form-control" type="text" name="mensaje" rows="3"></textarea>
                            </div>
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn" type="submit">
                                    Enviar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
