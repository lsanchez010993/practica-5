<?php
function leerArticulo()
{
    $result = [
        'id' => null,
        'titulo' => '',
        'contenido' => '',
        'errores' => []
    ];
    $result['id'] = $_GET['id'];

    require_once "../../modelo/articulo/obtenerArticuloPorId.php";
    $articulo = obtenerArticuloPorId($result['id']);

    if ($articulo) {
        $result['titulo'] = $articulo['titol'];
        $result['contenido'] = $articulo['cos'];
    } else {
        require_once '../../controlador/errores/errores.php';
        $result['errores'] = ErroresArticulos::ARTICULO_NO_ENCONTRADO;
    }

    return $result; // Devolver los datos y los errores para usarlos en la vista
}

function controllerModificarArticulo()
{

    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $id = $_GET['id'];
    require_once '../../controlador/errores/errores.php';
    if (isset($_GET['id'])) {

        $errores = [];

        if (empty($contenido)) {

            $errores[] = ErroresArticulos::CUERPO_MENSAJE_VACIO;
        }
        if (empty($titulo)) {
            $errores[] = ErroresArticulos::CAMPO_TITULO_VACIO;
        }
        if (empty($errores)) {
            return true;
        }

        return $errores;
    }
}

function actualizar_articulo($id, $titulo, $contenido)
{
    require_once "../../modelo/articulo/insertarArticulo.php";

    $resultado = actualizarArticulo($id, $titulo, $contenido);

    if ($resultado === true) {
       
        return Mensajes::MENSAJE_ACTUALIZACION_CORRECTA;
    }
}
