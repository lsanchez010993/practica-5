<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    iniciarSesion();
}

function iniciarSesion()
{
    try {
        require_once '../../modelo/conexion.php';
        require_once "../../controlador/errores/errores.php";
        $errores = "";
        $nombre_usuario = $_POST['nombre_usuario'];
        $password = $_POST['password'];

        $pdo = connectarBD();
        $sql = "SELECT id, password FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (verificarPassword_BD($usuario, $password, $nombre_usuario)) {
            // Si la contraseña es correcta, redirige
            header("Location: ../../index.php");
            exit();
        } else {
                       $errores = [ErroresInicioSesion::ERROR_INICIO_SESION];
            require_once '../../vista/usuaris/inicioSesion.form.php';
            return $errores;
        }
    } catch (PDOException $e) {
             error_log("Error al iniciar sesión: " . $e->getMessage());
        $errores = [ErroresInicioSesion::ERROR_INICIO_SESION];
        require_once '../../vista/usuaris/inicioSesion.form.php';
        return $errores;
    }
}
?>
