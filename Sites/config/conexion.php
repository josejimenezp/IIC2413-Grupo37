<?php
  try {
    #Pide las variables para conectarse a la base de datos.
    require('data.php'); 
    # Se crea la instancia de PDO
    $db_buques = new PDO("pgsql:dbname=$databaseName_buques;host=localhost;port=5432;user=$user_buques;password=$password_buques");
    $db_puertos = new PDO("pgsql:dbname=$databaseName_puertos;host=localhost;port=5432;user=$user_puertos;password=$password_puertos");
  } catch (Exception $e) {
    echo "No se pudo conectar a la base de datos: $e";
  }
?>
