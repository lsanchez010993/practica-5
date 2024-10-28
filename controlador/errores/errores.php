<?php

class ErroresPassword {
    const CONTRASEÑA_INCORRECTA = "La contrasela es incorrecta.";
    const CONTRASEÑAS_NO_COINCIDEN = "Las contraseñas no coinciden.";
    const CONTRASEÑA_VACIA = "La contraseña no puede estar vacía.";
    const CONTRASEÑA_CORTA = "La contraseña debe tener al menos 8 caracteres.";
    const CONTRASEÑA_SIN_NUMERO = "La contraseña debe contener al menos un número.";
    const CONTRASEÑA_SIN_MINUSCULA = "La contraseña debe contener al menos una letra minúscula.";
    const CONTRASEÑA_SIN_MAYUSCULA = "La contraseña debe contener al menos una letra mayúscula.";
}
class Mensajes{
    
    const MENSAJE_EXITO_CREAR_USUARIO = '¡Usuario registrado con éxito!';
    const MENSAJE_ACTUALIZACION_CORRECTA = 'El articulo ha sido modificado correctamente';
    const EXITO_INSERTAR_ARTICULO = 'Articulo insertado con exito';
    const CONFIRMAR_ACTUALIZACION = "¿Estás seguro de que quieres actualizar este artículo?";
    const CONFIRMAR_CREAR_ARTICULO = "¿Estás seguro de que quieres insertar un nuevo artículo?";
    const CONFIRMAR_ELIMINACION = "¿Estás seguro de que quieres eliminar este artículo?";
    const NO_ARTICULOS = "Aún no has insertado ningun artículo";

}
class ErroresArticulos{
    const ARTICULO_NO_ENCONTRADO = 'Articulo no encontrado';
    const CUERPO_MENSAJE_VACIO = 'El cuerpo del mensaje no puede estar vacio.';
    const CAMPO_TITULO_VACIO = 'El titulo no puede estar vacio.';
}
Class ErroresInicioSesion{
    const ERROR_INICIO_SESION = 'El usuario o la contraseña no son correctos';
    const ERROR_CREAR_USUARIO = 'Error al registrar el usuario.';
    const ERROR_USUARIO_REPETIDO ='El nombre de usuario ya está en uso.'; 
    const ERROR_EMAIL_REPETIDO ='El email ya está en uso.'; 
}





?>