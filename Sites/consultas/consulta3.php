<?php include('../templates/header.html');   ?>

<body>

<?php
  require("../config/conexion.php");


 	$consulta = "SELECT DISTINCT puertos.nombre FROM puertos, instalaciones WHERE
     instalaciones.tipo = 'astillero' AND puertos.puid = instalaciones.puid;";
	$resultado = $db -> prepare($consulta);
	$resultado -> execute();
	$puertos = $resultado -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre</th>
    </tr>
  <?php
	foreach ($puertos as $puerto) {
  		echo "<tr> <td>$puerto[0]</td>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>