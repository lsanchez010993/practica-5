<?php

function limit_articulos_por_pagina($start, $articlesPerPage, $usuario_id = null)
{
    try {
        require_once __DIR__ . '/../conexion.php';
        $pdo = connectarBD(); 

        if ($usuario_id !== null) {
            $sql = "SELECT * FROM articles WHERE usuario_id = :usuario_id LIMIT :start, :articlesPerPage";
            $stmt = $pdo->prepare($sql);
           
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':articlesPerPage', $articlesPerPage, PDO::PARAM_INT);
        } else {
            // Prepara la consulta sin usuario_id
            $sql = "SELECT * FROM articles LIMIT :start, :articlesPerPage";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':articlesPerPage', $articlesPerPage, PDO::PARAM_INT);
        }

        // Ejecuta la consulta y obtiene los resultados
        $stmt->execute();
        $articles = $stmt->fetchAll();

        return $articles;
    } catch (PDOException $e) {
        
        error_log("Error al obtener artículos con limitación de página: " . $e->getMessage());
        return false; // Devuelve false en caso de error
    }
}
?>
