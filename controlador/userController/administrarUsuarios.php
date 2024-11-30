<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es 'admin'
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['nombre_usuario'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once __DIR__.'../../../modelo/user/editarUsuarios.php';

$usuarios = verUsuarios();

// Cargar la vista y pasarle los datos
require_once __DIR__ . '../../../vista/usuaris/administrarUsuarios.php';
?>
