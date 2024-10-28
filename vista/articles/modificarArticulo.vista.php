<?php

require_once '../../controlador/userController/verificarSesion.php';
require_once '../../controlador/articuloController/modificarArticulo.controller.php';
require_once '../../controlador/errores/errores.php';

verificarSesion();
$exito = false;
$correcto = '';
$errores = [];
$resultado = [
    'id' => '',
    'titulo' => '',
    'contenido' => ''
];

// cargar los datos del artículo
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $resultado = leerArticulo();
    if (!empty($resultado['errores'])) {
        $errores = $resultado['errores'];
    }
}
// Si es POST, se procesa la actualización
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores previos del formulario enviados por POST
    $resultado['titulo'] = $_POST['titulo'];
    $resultado['contenido'] = $_POST['contenido'];

    $errores = controllerModificarArticulo();

    if ($errores === true) {
        $exito = true;
        $correcto = actualizar_articulo($_POST['id'], $_POST['titulo'], $_POST['contenido']);
    }
}

// Extraer datos del resultado
$id = $resultado['id'];
$titulo = $resultado['titulo'];
$contenido = $resultado['contenido'];

if (!empty($resultado['errores'])) {
    $errores = array_merge($errores, $resultado['errores']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Artículo</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
    <script>
        function confirmarActualizacion() {
            return confirm("<?php echo Mensajes::CONFIRMAR_ACTUALIZACION ?>");
        }
    </script>
</head>
<body>
    <h1>Modificar Artículo</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($id); ?>" method="POST" onsubmit="return confirmarActualizacion();">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($titulo); ?>"><br>

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" id="contenido"><?php echo htmlspecialchars($contenido); ?></textarea><br>
        <?php if (!$exito) echo '<button type="submit">Actualizar Artículo</button>' ?>
       
        <button type="button" onclick="location.href='../../index.php'">Atrás</button>
        <?php
        // Mostrar mensaje de éxito si el artículo se actualizó correctamente
        if (!empty($correcto)) {
            echo '<div class="correcto">' . htmlspecialchars($correcto) . '</div>';
        }

        // Mostrar los errores si los hay
        if (!empty($errores) && is_array($errores)) {
            echo '<div class="error">';
            foreach ($errores as $error) {
                echo htmlspecialchars($error) . '<br>';
            }
            echo '</div>';
        }
        ?>
    </form>



</body>

</html>