# Donde clonar si usan XAMPP o Laragon

Clonen el proyecto en la carpeta de su servidor web.

Si usan XAMPP, clonen en ./xampp/htdocs/

Si usan Laragon, clonen en ./laragon/www/

Si usan otro servidor web, clonen donde les parezca mejor.

# Modificar Datos de Conn.php

Cambien el nombre de la base de datos a la que vayan a usar en el archivo ./db/Conn.php.

# Estructura de los modulos (Arquitectura)

Cada modulo debe tener su propia carpeta dentro de ./modules/

Cada modulo debe tener archivos de modelos, controladores y vistas.

Los modelos deben contener la logica de acceso a datos.

Los controladores deben contener la logica de negocio.

Las vista deben contener la logica de presentacion.

# Base de Datos

![Diagrama de la Base de Datos](DB.png)