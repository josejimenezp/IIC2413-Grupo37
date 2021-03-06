<?php
session_start();
if (isset($_SESSION['username'])) {
    require("header.php");
} else {
    header("location: ../index.php");
}
?>

<?php

	// Obtenemos los parametros del form
	$sender_uid = $_GET['sender_uid'];
	$latitud = $_GET['latitud'];
	$longitud = $_GET['longitud'];
	$nombre_receptant = $_GET['nombre_receptant'];
	$apellido_receptant = $_GET['apellido_receptant'];
	$mensaje = $_GET['mensaje'];

	$nombre_completo = $nombre_receptant . ' ' . $apellido_receptant;

	if ($latitud == ''){
		echo <<< EOT
			<div class="row p-t-100 p-b-50">
				<div class="mx-auto">
					<h1>Error, latitud faltante</h1>
				</div>
			</div>
EOT;
	}
	elseif ($longitud == ''){
		echo <<< EOT
			<div class="row p-t-100 p-b-50">
				<div class="mx-auto">
					<h1>Error, longitud faltante</h1>
				</div>
			</div>
EOT;
	}
	elseif ($nombre_receptant == '' or $apellido_receptant == '' or $nombre_completo == ''){
		echo <<< EOT
			<div class="row p-t-100 p-b-50">
				<div class="mx-auto">
					<h1>Error, Debe ingresar el nombre completo de quién recibirá el mensaje</h1>
				</div>
			</div>
EOT;
	}
	else{

		// Primero obtenemos el uid del receptor en mongodb
		$data_uid = array('nombre' => $nombre_completo);
		$options_uid = array(
			'http' => array(
				'method' => 'GET',
				'content' => json_encode($data_uid),
				'header' => "Content-Type: application/json\r\n" .
							"Accept: application/json\r\n"
			)
		);

		$context_uid = stream_context_create( $options_uid );
		$result_uid = file_get_contents( "https://young-ocean-30844.herokuapp.com/_info-users", false, $context_uid);
		$response_uid = json_decode($result_uid, true);

		// Si el usuario no existe
		if ($response_uid == ''){
			echo <<< EOT
				<div class="row p-t-100 p-b-50">
					<div class="mx-auto">
						<h1>Error, el usuario ingresado no existe</h1>
					</div>
				</div>
EOT;
		}
		// Si es que existe el usuario
		else{

			// ID del receptor
			$receptant_uid = $response_uid[0]['uid'];

			$fecha = date('Y-m-d');

			// Se envía el mensaje
			
			$data_send = array('message' => $mensaje, 'sender' => intval($sender_uid),
							   'receptant' => intval($receptant_uid), 'lat' => $latitud,
							   'long' => $longitud, 'date' => $fecha);

			$options_send = array(
				'http' => array(
					'method' => 'POST',
					'content' => json_encode($data_send),
					'header' => "Content-Type: application/json\r\n" .
								"Accept: application/json\r\n"
				)
			);
	
			$context_send = stream_context_create( $options_send );
			$result_send = file_get_contents( "https://young-ocean-30844.herokuapp.com/messages", false, $context_send );
			$response_send = json_decode($result_send, true);

			if ($response_send['receptant']){
				require('template_mensaje_enviado.php');
			}
			elseif ($response_send['mensaje']){
				echo <<< EOT
					<div class="row p-t-100 p-b-50">
						<div class="mx-auto">
							<h1>Ha ocurrido un error</h1>
						</div>
					</div>
EOT;
			}
			else{
				echo <<< EOT
					<div class="row p-t-100 p-b-50">
						<div class="mx-auto">
							<h1>No se ha podido procesar tu solicitud</h1>
						</div>
					</div>
EOT;
			};
		};
	};
?>

<body>
	<div class="row p-t-10">
		<div class="col-4"></div>
		<div class="col-4"></div>
		<div class="col-3">
			<form action="send_msg.php" method="get">
				<button class="btn btn-primary" type="submit" value="return_to_send_msg">
					Volver a enviar un mensaje
				</button>
			</form>
		</div>
	</div>
</body>