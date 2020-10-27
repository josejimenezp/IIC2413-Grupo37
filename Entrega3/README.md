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

## Consideraciones Adicionales 📚
* Para facilitar la navegación en el sitio incluímos un 'navbar' al inicio de cada página conteniendo los links más relevantes como cerrar sesión, mi perfil, navieras y puertos. El resto de las funcionalidades pueden ser alcanzadas intuitivamente.
* Luego de realizar una búsqueda se debe utilizar el navbar para volver a otras páginas (Preferimos no crear un boton que redirigiera de vuelta a navieras o buques porque los links ya se encontraban en el navbar)

