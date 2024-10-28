<?php

function actualizarAnimal($id, $nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $es_mamifero)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Consulta de actualización con todos los campos relevantes
        $sql = "UPDATE animales 
                SET nombre_comun = :nombre_comun, 
                    nombre_cientifico = :nombre_cientifico, 
                    descripcion = :descripcion, 
                    ruta_imagen = :ruta_imagen, 
                    es_mamifero = :es_mamifero 
                WHERE id = :id";
                    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_comun', $nombre_comun);
        $stmt->bindParam(':nombre_cientifico', $nombre_cientifico);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ruta_imagen', $rutaImagen);
        $stmt->bindParam(':es_mamifero', $es_mamifero, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute(); // Devuelve true si se ejecuta correctamente
    } catch (PDOException $e) {
        error_log("Error al actualizar datos del animal: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}



function insertarAnimal($nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $usuario_id, $es_mamifero)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD();

        // Preparar la consulta SQL para insertar un nuevo registro en la tabla animales
        $sql = "INSERT INTO animales (nombre_comun, nombre_cientifico, descripcion, ruta_imagen, usuario_id, es_mamifero) 
                VALUES (:nombre_comun, :nombre_cientifico, :descripcion, :ruta_imagen, :usuario_id, :es_mamifero)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre_comun', $nombre_comun);
        $stmt->bindParam(':nombre_cientifico', $nombre_cientifico);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':ruta_imagen', $rutaImagen);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':es_mamifero', $es_mamifero, PDO::PARAM_BOOL);

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar un nuevo animal: " . $e->getMessage());
        return false;
    }
}



