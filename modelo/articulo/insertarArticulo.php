<?php

function actualizarArticulo($id, $titulo, $contenido)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Consulta de actualización
        $sql = "UPDATE articles SET titol = :titol, cos = :cos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':titol', $titulo);
        $stmt->bindParam(':cos', $contenido);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute(); // Devuelve true o false
    } catch (PDOException $e) {
      
        error_log("Error al actualizar el artículo: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}



function insertarArticulo($titulo, $contenido, $rutaImagen, $usuario_id)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Preparar la consulta SQL para insertar el artículo con el usuario_id
        $sql = "INSERT INTO articles (titol, cos, ruta_imagen, usuario_id) VALUES (:titol, :cos, :ruta_imagen, :usuario_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':titol', $titulo);
        $stmt->bindParam(':cos', $contenido);
        $stmt->bindParam(':ruta_imagen', $rutaImagen);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar el artículo: " . $e->getMessage());
        return false;
    }
}


