<?php include('../templates/header.html');   ?>

<body>

<?php
  require("../config/conexion.php");

  $puerto_elegido = $_POST["puerto_elegido"];

 	$consulta = "SELECT personal.nombre FROM personal, puertos, instalaciones WHERE
   instalaciones.puid = puertos.puid AND LOWER(puertos.nombre) = LOWER('%$puerto_elegido%') AND
   personal.rut = instalaciones.jefe_id;";
	$resultado = $db -> prepare($consulta);
	$resultado -> execute();
	$puerto = $resultado -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre</th>
  <?php
	foreach ($puerto as $jefe) {
      echo "<tr><td>$jefe[0]";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>