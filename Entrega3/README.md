# Entrega 3  

## Login 🔑  

Para hacer login en la aplicación hay que poner el nombre del usuario, es decir, nombre y apellido, y este se valida de manera indistinta si está escrito con mayúscula, minúscula o combinación de ambas. Para facilitar el ingreso les dejamos un usuario de jefes y otro de capitanes con sus respectivas contraseñas, las cuales modificamos, ya que al generarse aleatoriamente la de los demás usuarios, estas eran bastante extrañas.

* ### Datos de acceso como Admin  
  * **Jefes:**  
  Usuario: Garin Hills   
  Contraseña: hola123
  * **Capitanes:**  
  Usuario: Ajwa Daly  
  Contraseña: hola123

## Funcionalidad Adicional 🛠
Tanto la página de navieras como la de puertos tiene un buscador. Al ingresar por primera vez al listado de navieras/puertos se dirigirá a '`navieras.php`' / '`puertos.php`' (respectivamente) donde se muestran todas las navieras/puertos. Si el usuario decide utilizar el buscador, se le dirigirá a una segunda página, llamada '`busqueda.php`', donde se muestran los resultados de navieras y puertos que hayan calzado con la búsqueda. Es decir, si un usuario ingresa a 'Navieras' y realiza una búsqueda por una naviera también se buscará si existen puertos que calcen con la búsqueda. No importa de donde se realice la búsqueda ('`navieras.php`' o '`puertos.php`'), siempre se redirigirá a '`busqueda.php`'.  
Por último, la búsqueda es por el nombre de la entidad buscada.

## Procedimientos Almacenados 🛠  
El archivo stored_btn1.sql contiene las tres funciones creadas para obtener los días en las instalaciones donde la capacidad no fue agotada.  

Las funciones son:

* `fechas(fecha_entrada, fecha_salida)`:  
Los inputs de esta función corresponden al intervalo en el que se quiere saber si la capacidad está agotada y el output es una tabla con todos los días entre las fechas y otra columna con un 0 que representa el valor de la capacidad ocupada en un principio que luego se seteará, si corresponde, en la función capacidad_agotada.  

* `capacidad_agotada(fecha_entrada, fecha_salida, instalacion)`:  
Los inputs de esta función corresponden al intervalo en el que se quiere saber si la capacidad está agotada y el id de la instalación a comprobar.  
  * En esta función se crea una tabla auxiliar para añadir las fechas en que la instalación está sin disponibilidad, es decir, con una capacidad agotada de un 100%.  
  * La función funciona recorriendo cada una de las fechas entregada por la función fechas y evaluando si la capacidad es menor o igual a la cantidad de permisos otorgados para esa fecha en esa instalación. Si es menor o igual la capacidad agotada se setea en 100% (no hay disponibilidad para otro permiso) y se agrega a la tabla auxiliar. En otro caso, se calcula la capacidad_agotada y se setea en la tabla creada por la función fechas. Finalmente, se obtiene la diferencia entre la tabla entregada por la función fechas y la tabla auxiliar para así eliminar las fechas en donde no haya disponibilidad para otorgar permisos.  
    
* `porcentaje_prom()`:  
Esta función calcula el promedio de la capacidad entre el intervalo de fechas en que se quería conocer si existía capacidad. Este promedio es entregado por instalación.


## Consideraciones Adicionales 📚
* Para facilitar la navegación en el sitio incluímos un 'navbar' al inicio de cada página conteniendo los links más relevantes como cerrar sesión, mi perfil, navieras y puertos. El resto de las funcionalidades pueden ser alcanzadas intuitivamente.
* Luego de realizar una búsqueda se debe utilizar el navbar para volver a otras páginas (Preferimos no crear un boton que redirigiera de vuelta a navieras o buques porque los links ya se encontraban en el navbar).
* Nuestra homepage es el perfil del usuario.

