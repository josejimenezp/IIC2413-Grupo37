<?php include('templates/header.html');   ?>

<body>
  <h1 align="center">Biblioteca Portuaria </h1>
  <p style="text-align:center;">Aquí podrás encontrar información sobre barcos.</p>

  <br>

  <h3 align="center"> ¿Quieres ver todos los puertos junto a la ciudad que pertenecen?</h3>

  <form align="center" action="consultas/consulta1.php" method="post">
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres buscar un los jefes de las instalaciones por su puerto?</h3>

  <form align="center" action="consultas/consulta2.php" method="post">
    Puerto:
    <input type="text" name="puerto_elegido">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>

  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres conocer todos los puertos con al menos un astillero?</h3>

  <form align="center" action="consultas/consulta3.php" method="post">
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres ver todos los atraques de un barco en un puerto?</h3>

<form align="center" action="consultas/consulta4.php" method="post">
  Barco:
  <input type="text" name="barco_elegido">
  <br/><br/>
  Puerto:
  <input type="text" name="puerto_elegido">
  <br/><br/>
  <input type="submit" value="Buscar">
</form>
<br>
<br>
<br>

<h3 align="center"> ¿Quieres ver la edad promedio de los trabajadores en cada puerto?</h3>

<form align="center" action="consultas/consulta5.php" method="post">
  <input type="submit" value="Buscar">
</form>
<br>
<br>
<br>


  <h3 align="center">¿Quieres buscar todos los pokemones por tipo?</h3>

  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT tipo FROM pokemones;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  
<h3 align="center"> ¿Quieres ver el puerto que recibió más barcos en un mes y año?</h3>

<form align="center" action="consultas/consulta6.php" method="post">
  Mes:
  <input type="text" name="mes_elegido">
  <br/><br/>
  Año:
  <input type="text" name="año_elegido">
  <br/><br/>
  <input type="submit" value="Buscar">
</form>
<br>
<br>
<br>


  <form align="center" action="consultas/consulta_tipo.php" method="post">
    Seleccinar un tipo:
    <select name="tipo">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por tipo">
  </form>

  <br>
  <br>
  <br>
  <br>
</body>
</html>
