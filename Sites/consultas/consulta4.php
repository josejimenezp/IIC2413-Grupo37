<?php include('../templates/header.html');   ?>

<body>

<?php
  require("../config/conexion.php");

  $puerto_elegido = $_POST["puerto_elegido"];
  $barco_elegido = $_POST["barco_elegido"];

  $consulta = "SELECT barcos.nombre, permisos.fecha_atraque FROM instalaciones, puertos,
    permisos, barcos WHERE instalaciones.puid = puertos.puid AND LOWER(puertos.nombre) LIKE LOWER('%$puerto_elegido%') AND 
    permisos.iid = instalaciones.iid AND LOWER(barcos.nombre) LIKE LOWER('%$barco_elegido%') AND 
    barcos.patente = permisos.patente;";
  $resultado = $db -> prepare($consulta);
  $resultado -> execute();
  $puerto = $resultado -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre</th>  
      <th>Fecha atraque</th>
    <tr>
  <?php
	foreach ($puerto as $jefe) {
      echo "<tr><td>$jefe[0]</td> <td>$jefe[1]</td>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>