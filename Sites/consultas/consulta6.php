<?php include('../templates/header.html');   ?>

<body>

<?php

  $meses = array(
    "enero" => "01",
    "febrero" => "02",
    "marzo" => "03",
    "abril" => "04",
    "mayo" => "05",
    "junio" => "06",
    "julio" => "07",
    "agosto" => "08",
    "septiembre" => "09",
    "octubre" => "10",
    "noviembre" => "11",
    "diciembre" => "12"
  );
  require("../config/conexion.php");

  $mes_elegido = $meses[strtolower($_POST["mes_elegido"])];
  $año_elegido = $_POST["año_elegido"];

  $consulta = "SELECT puertos.nombre, COUNT(permisos.patente) FROM permisos, puertos,
  barcos, instalaciones WHERE permisos.patente = barcos.patente AND
  puertos.puid = instalaciones.puid AND permisos.iid = instalaciones.iid AND
  EXTRACT(MONTH FROM permisos.fecha_atraque) = $mes_elegido AND EXTRACT(YEAR
  FROM permisos.fecha_atraque) = '$año_elegido' GROUP BY puertos.nombre ORDER BY
  COUNT(permisos.patente) DESC FETCH FIRST ROW ONLY;";

  $resultado = $db -> prepare($consulta);
  $resultado -> execute();
  $puerto = $resultado -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre</th>  
      <th>Cantidad de atraques</th>
    <tr>
  <?php
	foreach ($puerto as $jefe) {
      echo "<tr><td>$jefe[0]</td> <td>$jefe[1]</td>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>