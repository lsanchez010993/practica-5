<!-- vista/editarPerfilVista.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <style>
        form {
            width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="file"], button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .mensaje {
            color: green;
        }
        .error {
            color: red;
        }
        .avatar {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Editar Perfil Personal</h1>
    <?php if ($mensaje): ?>
        <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre_usuario">Nickname:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" required>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>

        <label for="avatar">Foto de Perfil:</label>
        <input type="file" name="avatar" id="avatar">

        <?php if ($usuario['avatar']): ?>
            <div class="avatar">
                <p>Avatar actual:</p>
                <img src="<?php echo htmlspecialchars('../../vista/' . $usuario['avatar']); ?>" alt="Avatar" width="100">

            </div>
        <?php endif; ?>

        <button type="submit">Actualizar Perfil</button>
        <button type="button" onclick="location.href='../../index.php'">Atrás</button>
    </form>
</body>
</html>
