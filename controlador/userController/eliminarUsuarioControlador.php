<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es 'admin'
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// require_once '../modelo/usuarioModelo.php';
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

    // Manejar la eliminación del usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = $_POST['accion'];

        if ($accion === 'eliminar_todo') {
            // Eliminar los artículos del usuario
            eliminarArticulosDeUsuario($id);
        } elseif ($accion === 'conservar_articulos') {
            // Reasignar los artículos al usuario anonymous
            $idAnonimo = obtenerIdUsuarioAnonimo();
            if ($idAnonimo === false) {
                echo "No se pudo obtener el ID del usuario anonymous.";
                exit();
            }
            reasignarArticulosAAnonimo($id, $idAnonimo);
        }

        // Eliminar el usuario
        $eliminado = eliminarUsuario($id);

        if ($eliminado) {
            // Redirigir a la lista de usuarios después de la eliminación
            header("Location: administrarUsuarios.php");
            exit();
        } else {
            $error = "Error al eliminar el usuario.";
        }
    }
} else {
    echo "ID de usuario inválido.";
    exit();
}

// Cargar la vista y pasarle los datos
require_once __DIR__ . '../../../vista/usuaris/eliminarUsuarioVista.php';
?>
