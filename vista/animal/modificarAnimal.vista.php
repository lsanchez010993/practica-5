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
    'nombre_comun' => '',
    'nombre_cientifico' => '',
    'descripcion' => '',
    'ruta_imagen' => '', // Inicializar ruta_imagen para evitar errores
    'es_mamifero' => ''
];

// cargar los datos del animal
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $resultado = leerAnimal();
    if (!empty($resultado['errores'])) {
        $errores = $resultado['errores'];
    }
}
// Si es POST, se procesa la actualización
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario enviados por POST
    $resultado['nombre_comun'] = $_POST['nombre_comun'];
    $resultado['nombre_cientifico'] = $_POST['nombre_cientifico'];
    $resultado['descripcion'] = $_POST['descripcion'];
    $resultado['es_mamifero'] = isset($_POST['es_mamifero']) ? 1 : 0;

    // Manejo de imagen cargada
    if (isset($_FILES['ruta_imagen']) && $_FILES['ruta_imagen']['error'] === UPLOAD_ERR_OK) {
        $rutaTemporal = $_FILES['ruta_imagen']['tmp_name'];
        $nombreArchivo = uniqid('img_', true) . '.' . pathinfo($_FILES['ruta_imagen']['name'], PATHINFO_EXTENSION);
        $rutaDestino = __DIR__ . '/../../vista/imagenes/imagenes/' . $nombreArchivo;
        
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            $resultado['ruta_imagen'] = 'imagenes/imagenes/' . $nombreArchivo;
        } else {
            $errores[] = 'Error al guardar la imagen en el servidor.';
        }
    }

    $errores = controllerModificarAnimal();

    if ($errores === true) {
        $exito = true;
        $correcto = actualizar_animal(
            $_POST['id'],
            $_POST['nombre_comun'],
            $_POST['nombre_cientifico'],
            $_POST['descripcion'],
            $resultado['ruta_imagen'],
            $resultado['es_mamifero']
        );
    }
}

// Extraer datos del resultado
$id = $resultado['id'];
$nombre_comun = $resultado['nombre_comun'];
$nombre_cientifico = $resultado['nombre_cientifico'];
$descripcion = $resultado['descripcion'];
$ruta_imagen = $resultado['ruta_imagen'];
$es_mamifero = $resultado['es_mamifero'];

if (!empty($resultado['errores'])) {
    $errores = array_merge($errores, $resultado['errores']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Animal</title>
    <link rel="stylesheet" href="../estils/estilos_formulario.css">
    <script>
        function confirmarActualizacion() {
            return confirm("¿Estás seguro de que deseas actualizar este animal?");
        }
    </script>
</head>

<body>
    <h1>Modificar Animal</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($id); ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirmarActualizacion();">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <label for="nombre_comun">Nombre Común:</label>
        <input type="text" name="nombre_comun" id="nombre_comun" value="<?php echo htmlspecialchars($nombre_comun); ?>" required><br>

        <label for="nombre_cientifico">Nombre Científico:</label>
        <input type="text" name="nombre_cientifico" id="nombre_cientifico" value="<?php echo htmlspecialchars($nombre_cientifico); ?>" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($descripcion); ?></textarea><br>

        <label for="ruta_imagen">Imagen:</label>
        <input type="file" name="ruta_imagen" id="ruta_imagen" accept="image/*"><br>
        
        <?php if (!empty($ruta_imagen)): ?>
            <p>Imagen actual:</p>
            <img src="../../<?php echo htmlspecialchars($ruta_imagen); ?>" alt="Imagen del animal" width="150" height="100"><br>
        <?php endif; ?>

        <label for="es_mamifero">¿Es Mamífero?</label>
        <input type="checkbox" name="es_mamifero" id="es_mamifero" value="1" <?php echo $es_mamifero ? 'checked' : ''; ?>><br>

        <?php if (!$exito) echo '<button type="submit">Actualizar Animal</button>'; ?>

        <button type="button" onclick="location.href='../../index.php'">Atrás</button>

        <?php
        // Mostrar mensaje de éxito si el animal se actualizó correctamente
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
