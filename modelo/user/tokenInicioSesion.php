<?php

if (isset($_SESSION['nombre_usuario'])){
    session_start();
}

 // Asegúrate de que esté en la primera línea del script.

function almacenarTokenEnBD($nombre_usuario, $token)
{
    // require_once '../../modelo/conexion.php';

    $pdo = connectarBD();
   


    $sql = "UPDATE usuarios SET token = :token WHERE nombre_usuario = :nombre_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->execute();
   
}

function verificarTokenSesion()
{
    // require_once '../../modelo/conexion.php';
    if (isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];

        // Consultar la base de datos para verificar el token
        $pdo = connectarBD();
        $stmt = $pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Restaurar la sesión

            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            return true;
        } else {
            // Token no válido, eliminar cookie
            setcookie('remember_me', '', time() - 3600, "/"); // Eliminar la cookie
        }
    }
    return false;
}
function cerrarSesion()
{
    
    require_once '../../modelo/conexion.php';
    $nombre_usuario = $_SESSION['nombre_usuario'];

    // Limpiar el token de la base de datos
    $pdo = connectarBD();
    $stmt = $pdo->prepare("UPDATE usuarios SET token = NULL WHERE nombre_usuario = :nombre_usuario");
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->execute();
    
    // Eliminar la cookie y destruir la sesión
    setcookie('remember_me', '', time() - 3600, "/");
    session_unset();
    session_destroy();
}
