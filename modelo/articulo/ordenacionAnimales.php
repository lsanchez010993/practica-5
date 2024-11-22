<?php
// modelo/animalModel.php
require_once __DIR__ . '../../conexion.php';

function obtenerAnimalesDesdeModelo($start, $articulosPorPagina, $columnaOrden, $direccionOrden) {
    try {
        $pdo = connectarBD();

        // Preparar la consulta con el orden especificado
        $sql = "SELECT * FROM animales ORDER BY $columnaOrden $direccionOrden LIMIT :start, :limit";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $articulosPorPagina, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener animales: " . $e->getMessage());
        return [];
    }
}
?>