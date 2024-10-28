<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    eliminarArticulo($id);
} else {
    echo "No se ha proporcionado un ID válido para eliminar el artículo.";
}


function eliminarArticulo($id)
{
    try {
        require_once __DIR__ . '/../conexion.php';

        $pdo = connectarBD();
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Si el artículo se elimina correctamente, redirige a index
        header("Location: ../../index.php");
        exit();
    } catch (PDOException $e) {
     
        error_log("Error al eliminar el artículo: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
?>
