<?php include('../templates/header.html');   ?>

<body>

<?php
  require("../config/conexion.php");


 	$consulta = "SELECT nombre, ciudad FROM puertos;";
	$resultado = $db -> prepare($consulta);
	$resultado -> execute();
	$puertos = $resultado -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre</th>
      <th>Ciudad</th>
    </tr>
  <?php
	foreach ($puertos as $puerto) {
  		echo "<tr> <td>$puerto[0]</td> <td>$puerto[1]</td>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>