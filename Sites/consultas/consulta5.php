<?php include('../templates/header.html');   ?>

<body>

<?php
  require("../config/conexion.php");


 	$consulta = "SELECT puertos.nombre, AVG(personal.edad) FROM puertos, personal,
     instalaciones WHERE puertos.puid = instalaciones.puid AND personal.iid =
     instalaciones.iid GROUP BY puertos.nombre;";
	$resultado = $db -> prepare($consulta);
	$resultado -> execute();
	$puertos = $resultado -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre del puerto</th>
      <th>Edad promedio</th>
    </tr>
  <?php
	foreach ($puertos as $trabajador) {
  		echo "<tr> <td>$trabajador[0]</td> <td>$trabajador[1]</td>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>