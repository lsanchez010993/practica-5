# practica4-php

A groso modo:

El codigo está comentado. No he hecho nada que se salga de lo común. El código funciona bien. Las validaciones funcionan bien y las diferentes paginas de la vista funcionan como se espera de ellas.

Las sesions las he implementado correctamente para controlar las sesiones de usuario (no muestro mensajes de error con ellas). 

CAMBIO REALIZADO EN LA ULTIMA SEMANA: Utilizo las cookies en el controlador de inicioSesion para recordar al usuario.

He aplicado un CSS superficial para mostrar las diferentes vistas.

He dividido el codigo en modelo/vista/controlador, haciéndolo modular. 

He utilizado constantes para mostrar los diferentes textos (mensajes de error, advertencias o notificaciones).

Mediante PHP compruebo que los nombres de usuario y los correos sean unicos en la BD antes permitir que el usuario se registre. 

Valido que el password cumpla los requisitos de seguridad.

Todas las validaciones/comprobaciones verifican los datos antes de realizar la consulta sql. Tanto para insertar articulo como para modificarlo, registrar un nuevo usuario o iniciar sesion.



IMPORTANTE:

USUARIOS DE LA BD:
1234
luis
paco
admin


CONTRASEÑA ÚNICA:
!Q"W12qw

# practica5-php


## Tabla de Contenidos
- [Características](#características)
- [Configuraciones de Seguridad](#configuraciones-de-seguridad)
- [Licencia](#licencia)


## Características
- Estructura de código modular siguiendo el patrón MVC
- Registro de usuarios con verificación de nombres de usuario y correos únicos
- Validación de contraseñas para cumplir con requisitos de seguridad
- Gestión adecuada de sesiones para autenticación de usuarios
- Implementación de cookies para recordar a los usuarios durante el inicio de sesión
- Validación de entradas antes de ejecutar consultas SQL
- Uso de constantes para mostrar mensajes y notificaciones
- Estilo CSS básico para mejorar la interfaz de usuario


## Configuraciones de Seguridad
- **Verificación de Usuarios Únicos**: Se realizan comprobaciones para asegurar que los nombres de usuario y correos electrónicos sean únicos antes del registro.
- **Validación de Contraseñas**: Las contraseñas se validan para cumplir con estándares de seguridad, incluyendo requisitos de complejidad.
- **Validación de Entradas**: Todos los datos se validan en el servidor antes de ejecutar consultas SQL para prevenir inyecciones SQL.
- **Gestión de Sesiones**: El manejo adecuado de sesiones garantiza la autenticación y autorización de usuarios.
- **Implementación de Cookies**: Las cookies se usan en el controlador de inicio de sesión para recordar de forma segura a los usuarios.
- **Constantes para Mensajes**: Los mensajes de error y notificaciones se gestionan usando constantes para consistencia.


