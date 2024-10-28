<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errores = [];
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];
    require_once "../../controlador/userController/iniciarSesion.controller.php";
    $errores = iniciarSesionController($nombre_usuario, $password);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
</head>

<body>
    <h1>Inicio de sesión</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" value="<?php echo isset($nombre_usuario) ? htmlspecialchars($nombre_usuario) : ''; ?>" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <label>
            <input type="checkbox" name="recordar" <?php echo isset($_COOKIE['nombre_usuario']) ? 'checked' : ''; ?>>
            Recordarme
        </label><br>

        <button type="submit">Iniciar Sesión</button>
        <button type="button" onclick="location.href='../../index.php'">Atrás</button>

        <?php
        // Mostrar errores si existen
        if (!empty($errores)) {
            foreach ($errores as $error) {
                if (strpos($error, '!') !== false) {
                    echo '<p class="correcto">' . htmlspecialchars($error) . '</p>';
                } else {
                    echo '<p class="error">' . htmlspecialchars($error) . '</p>';
                }
            }
        }
        ?>
    </form>

</body>

</html>
