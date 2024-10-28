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
paca
pepe
pedro

CONTRASEÑA ÚNICA:
!Q"W12qw