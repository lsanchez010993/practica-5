<?php
session_start();
$session_iniciada = isset($_SESSION['nombre_usuario']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="vista/estils/estils_Index.css">
</head>

<body>

    <!-- Banner en la parte superior -->
    <header class="banner">
        <?php if ($session_iniciada) {
            $nombre = $_SESSION['nombre_usuario'];
            echo "<span class='nombre_usuario'>Bienvenido: $nombre</span>";
        } ?>
        <div class="menu menu-right">
            <button class="menu-toggle"><?php echo $session_iniciada ? 'Menú' : 'No has iniciado sesión'; ?></button>

            <div class="menu-content">
                <?php
                if (!$session_iniciada) {
                    // Opciones si la sesión no está iniciada
                    echo <<<HTML
                <button onclick="location.href='vista/usuaris/inicioSesion.form.php'">Iniciar Sesión</button>
                <button onclick="location.href='vista/usuaris/crearUsuario.php'">Registrarse</button>
HTML;
                } else {
                    echo <<<HTML
                <button onclick="location.href='vista/animal/insertarNuevoAnimal.php'">Insertar Nuevo Artículo</button>
                <button onclick="location.href='modelo/user/cerrarSesion.php'">Cerrar Sesión</button>
                <button onclick="location.href='vista/usuaris/cambiarPass.php'">Cambiar Password</button>
                
HTML;
                }
                ?>
            </div>
        </div>
    </header>

    <!-- Resto del contenido de la página -->
    <main>
        <?php include_once 'vista/animal/vistaAnimales.php'; ?>
    </main>

</body>

</html>