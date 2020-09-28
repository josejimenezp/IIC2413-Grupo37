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

</body>
</html>
