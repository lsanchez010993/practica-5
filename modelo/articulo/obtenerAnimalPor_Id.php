<?php
function obtenerAnimalPor_Id($id) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT * FROM animales WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      
        error_log("Error al obtener el animal por ID: " . $e->getMessage());
        return false; 
    }
}
function obtenerAnimalPorNombre($nombre_comun) {
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();
        $sql = "SELECT * FROM animales WHERE nombre_comun LIKE :nombre_comun";
        $stmt = $pdo->prepare($sql);
        $nombre_comun = $nombre_comun . '%'; // Agregar el comodín para buscar por inicio de palabra
        $stmt->bindParam(':nombre_comun', $nombre_comun, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Usamos fetchAll para devolver todas las coincidencias
    } catch (PDOException $e) {
        error_log("Error al obtener los animales por nombre común: " . $e->getMessage());
        return false; 
    }
}

?>
