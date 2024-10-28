<?php
require_once '../../controlador/userController/verificarSesion.php';
require_once '../../controlador/articuloController/insertarArticuloController.php';
require_once '../../controlador/errores/errores.php';

verificarSesion();

$titulo = '';
$contenido = '';
$errores = [];
$correcto = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //La función list() en PHP permite asignar varios valores a múltiples variables desde un array 
    // o una lista de valores devueltos por una función. Es una forma práctica de descomponer un array
    //  o una estructura similar y asignar cada elemento a una variable individual.
    list($errores, $correcto) = procesarFormulario();

    
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
}
//Si es correcto borra el titulo y el contenido de las variables
if (!empty($correcto)) {
    $titulo = '';
    $contenido = '';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Artículo</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
    <script>
        function confirmarCreacion() {
            return confirm("<?php echo Mensajes::CONFIRMAR_CREAR_ARTICULO ?>");
        }
    </script>
</head>

<body>
    <h1>Crear Artículo</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmarCreacion();">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($titulo); ?>"><br>

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" id="contenido"><?php echo htmlspecialchars($contenido); ?></textarea><br>

        <label for="imagen">Selecciona una imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>

        <button type="submit">Crear Artículo</button>
        <button type="button" onclick="location.href='../../index.php'">Atrás</button>
    </form>

    <?php
    // Mostrar errores si existen
    if (!empty($errores)) {
        echo '<div class="error">';
        foreach ($errores as $error) {
            echo htmlspecialchars($error) . '<br>';
        }
        echo '</div>';
    }
    // Mostrar mensaje de éxito si existe
    if (!empty($correcto)) {
        echo '<div class="correcto">' . htmlspecialchars($correcto) . '</div>';
    }
    ?>
</body>

</html>
