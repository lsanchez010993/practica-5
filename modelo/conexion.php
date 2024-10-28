<?php
function connectarBD() {
    $host = 'localhost';
    $dbname = 'pt04_luis_sanchez';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error en la connexió: " . $e->getMessage());
    }
}
?>
