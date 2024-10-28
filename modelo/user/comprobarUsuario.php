<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim(strtolower($_POST['nombre_usuario']));
}

function usuarioRepetido($usuario)
{
    try {
        require_once '../../modelo/conexion.php';

        $pdo = connectarBD();

        // Consulta para verificar si el usuario ya existe
        $sql = "SELECT COUNT(*) FROM usuarios WHERE LOWER(nombre_usuario) = :nombre_usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $usuario);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    } catch (PDOException $e) {
        // Manejar la excepción PDO
        error_log("Error al verificar si el usuario está repetido: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
?>
