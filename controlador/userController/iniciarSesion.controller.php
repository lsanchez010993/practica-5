<?php
function iniciarSesionController( $nombre_usuario,  $password){


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];
    // Validación de la contraseña. Antes de hacer la conexión a la base de datos, compruebo si el password cumple los requisitos.
    require_once "validarPassword.php";
    $password_ok = comprobarPassword($password);

    if ($password_ok === true) {
        include '../../modelo/user/iniciarSesion.php';
        
        $errores = iniciarSesion();

    
        if (empty($errores)) {
            
            if (isset($_POST['recordar'])) {
                //  La cookie esta activa  30 días
                setcookie('nombre_usuario', $nombre_usuario, time() + (30 * 24 * 60 * 60), "/");
            } else {
                // Si ya existe: Eliminar la cookie 
                if (isset($_COOKIE['nombre_usuario'])) {
                    setcookie('nombre_usuario', '', time() - 3600, "/");
                }
            }

           //Si el usuario inicia sesion se redirige al index
            header("Location: ../../index.php");
            exit();
        }
    } else {
        $errores = [ErroresPassword::CONTRASEÑA_INCORRECTA];
    }
} else {
    
    $nombre_usuario = isset($_COOKIE['nombre_usuario']) ? $_COOKIE['nombre_usuario'] : '';
}
return $errores;
}
?>