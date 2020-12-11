# Entrega 5

## Login

Para iniciar sesión, se debe ingresar con el nombre de usuario y contraseña. El nombre de usuario corresponde al nombre y apellido de la persona. Algunos usuarios con mensajes enviados o recibidos:

| Usuario         | Contraseña  |
|-----------------|-------------|
| Ace Stephenson  | hola123     |
| Rita Kouma      | hola123     |
| Manuel Frazier  | hola123     |


## Revisar mensajes

Desde la barra superior, donde dice "Mensajes", se accede a los mensajes recibidos y enviados. En esa sección, hay una barra lateral y los mensajes recibidos. Desde la barra, se pueden ver los mensajes recibidos, enviados, se puede redactar un nuevo mensaje y acceder al buscador.

## Buscador

En el buscador se puede ingresar palabras claves: desired, required y forbidden. Al buscar, se redirige a otra vista, donde se muestran los resultados. Para realizar otra búsqueda o volver a ver mensajes, se usa la barra lateral.

## Redactar un mensaje

Para redactar un mensaje, se debe acceder mediante la barra superior o en la barra lateral de la sección "Mensajes". Para enviar un mensaje, se necesita el nombre y apellido del receptor.

## PDI

En la sección "Mi perfil" hay un botón donde se puede acceder a las funciones de la PDI. Para buscar las ubicaciones de mensajes, se ingresa un ID de usuario, un rango de fechas y palabras clave, entregando la información requerida en un mapa.
Para distinguir las ubicaciones se generaron dos markers, uno azul y uno verde, los cuales muestran los mensajes tanto enviados como recibidos y la información según el cargo de la persona respectivamente. Esta última depende de si es capitán o jefe, donde se mostrarán los puertos en los que ha estado el barco que capitanea o el puerto donde trabaja el jefe.

Las palabras claves deben estar separadas por coma.

## Otros

Se agregó la función ``get_mongo_user`` en el archivo "main.py" la cual corresponde a una consulta de tipo GET que entrega el id de la base de mongoDB respecto a un id de la base PSQL dado. 

