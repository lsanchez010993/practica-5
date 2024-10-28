<?php
function obtenerArticuloPorId($id) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT * FROM articles WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      
        error_log("Error al obtener el artículo por ID: " . $e->getMessage());
        return false; 
    }
}
?>
