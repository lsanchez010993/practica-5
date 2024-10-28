<?php
function leerAnimal()
{
    $result = [
        'id' => '',
        'nombre_comun' => '',
        'nombre_cientifico' => '',
        'descripcion' => '',
        'ruta_imagen' => '',
        'es_mamifero' => ''
    ];
    $result['id'] = $_GET['id'];

    require_once "../../modelo/articulo/obtenerArticuloPorId.php";
    $animal = obtenerArticuloPorId($result['id']);

    if ($animal) {
        $result['nombre_comun'] = $animal['nombre_comun'];
        $result['nombre_cientifico'] = $animal['nombre_cientifico'];
        $result['descripcion'] = $animal['descripcion'];
        $result['ruta_imagen'] = $animal['ruta_imagen'];
        $result['es_mamifero'] = $animal['es_mamifero'];
       
    } else {
        require_once '../../controlador/errores/errores.php';
        $result['errores'] = ErroresArticulos::ARTICULO_NO_ENCONTRADO;
    }

    return $result; // Devolver los datos y los errores para usarlos en la vista
}

function controllerModificarAnimal()
{
    require_once '../../controlador/errores/errores.php';

    $nombre_comun = $_POST['nombre_comun'];
    $nombre_cientifico = $_POST['nombre_cientifico'];
    $descripcion = $_POST['descripcion'];
    $es_mamifero = isset($_POST['es_mamifero']) ? $_POST['es_mamifero'] : null;
    $errores = [];

    // Validación de los campos
    if (empty($nombre_comun)) {
        $errores[] = "El campo 'Nombre Común' no puede estar vacío.";
    }
    if (empty($nombre_cientifico)) {
        $errores[] = "El campo 'Nombre Científico' no puede estar vacío.";
    }
    if (empty($descripcion)) {
        $errores[] = "El campo 'Descripción' no puede estar vacío.";
    }

    // Validación del campo es_mamifero (booleano)
    if ($es_mamifero !== '0' && $es_mamifero !== '1') {
        $errores[] = "El campo 'Es Mamífero' debe estar seleccionado correctamente.";
    }

    // Si no hay errores, retornar true para proceder con la actualización
    if (empty($errores)) {
        return true;
    }

    // Si hay errores, devolver el array de errores
    return $errores;
}


function actualizar_animal($id, $nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $es_mamifero)
{
    require_once "../../modelo/articulo/insertarArticulo.php";

    $resultado = actualizarAnimal($id, $nombre_comun, $nombre_cientifico, $descripcion, $rutaImagen, $es_mamifero);

    if ($resultado === true) {
       
        return Mensajes::MENSAJE_ACTUALIZACION_CORRECTA;
    }
}
