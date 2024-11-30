<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es 'admin'
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once __DIR__.'../../../modelo/user/editarUsuarios.php';

// Verificar si se recibió el ID del usuario
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del usuario
    $usuario = obtenerUsuarioPorId($id);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit();
    }

    // Manejar la actualización del usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_usuario = trim($_POST['nombre_usuario']);
        $email = trim($_POST['email']);

        // Validar los datos (puedes agregar más validaciones según tus necesidades)
        if (empty($nombre_usuario) || empty($email)) {
            $error = "Todos los campos son obligatorios.";
        } else {
            // Actualizar el usuario en la base de datos
            $actualizado = actualizarUsuario($id, $nombre_usuario, $email);

            if ($actualizado) {
                // Redirigir a la lista de usuarios después de la actualización
                header("Location: administrarUsuarios.php");
                exit();
            } else {
                $error = "Error al actualizar el usuario.";
            }
        }
    }
} else {
    echo "ID de usuario inválido.";
    exit();
}

// Cargar la vista y pasarle los datos
require_once __DIR__ . '../../../vista/usuaris/editarUsuarioVista.php';
?>
