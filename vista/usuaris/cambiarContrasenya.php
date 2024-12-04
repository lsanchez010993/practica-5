<?php

// Asignar el token
$token = trim($_GET['token'] ?? '');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h1>Cambiar Contraseña</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <?php if (isset($mensaje)) { echo "<p style='color:green;'>$mensaje</p>"; } ?>
    <form action="../../controlador/userController/procesarCambioContrasenya.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" id="password" >
        <label for="password_confirm">Confirmar Contraseña:</label>
        <input type="password" name="password_confirm" id="password_confirm" >
        <button type="submit">Cambiar Contraseña</button>
        
    </form>
</body>
</html>
