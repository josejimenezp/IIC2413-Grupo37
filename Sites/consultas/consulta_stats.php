<?php include('../templates/header.html');   ?>

<body>
<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  $puerto_elegido = $_POST["puerto_elegido"];

 	$query = "SELECT personal.nombre FROM personal, puertos, instalaciones WHERE
   instalaciones.puid = puertos.puid AND puertos.nombre = $puerto_elegido AND
   personal.rut = instalaciones.jefe_id;";
	$result = $db -> prepare($query);
	$result -> execute();
	$pokemones = $result -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre</th>
  <?php
	foreach ($pokemones as $pokemon) {
  		echo "<tr><td>$pokemon[0]";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>