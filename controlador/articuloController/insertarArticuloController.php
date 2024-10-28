<?php

require_once '../../controlador/userController/verificarSesion.php';
require_once '../../modelo/articulo/insertarArticulo.php';
require_once '../../controlador/errores/errores.php';

verificarSesion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



function procesarFormulario()
{
    $errores = [];
    $correcto = '';

  
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);

  
    if (empty($titulo)) {
        $errores[] = 'El título es obligatorio.';
    }

  
    if (empty($contenido)) {
        $errores[] = 'El contenido es obligatorio.';
    }

  
    $rutaImagenBD = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        
        $rutaImagenes = __DIR__ . '/../../vista/imagenes/imagenes/';

       
        if (!is_dir($rutaImagenes)) {
            mkdir($rutaImagenes, 0755, true);
        }

      
        $nombreArchivo = $_FILES['imagen']['name'];
    
        $rutaTemporal = $_FILES['imagen']['tmp_name'];

        
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extensionArchivo = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        if (in_array(strtolower($extensionArchivo), $extensionesPermitidas)) {
            // Generar un nombre único para evitar colisiones
            $nombreArchivoSeguro = uniqid('img_', true) . '.' . $extensionArchivo;

           
            $rutaDestino = $rutaImagenes . $nombreArchivoSeguro;

            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                // El archivo se ha subido correctamente
                // Guardar la ruta relativa o el nombre del archivo en la base de datos
                $rutaImagenBD = 'imagenes/imagenes/' . $nombreArchivoSeguro;
            } else {
                // Error al mover el archivo
                $errores[] = 'Error al guardar la imagen en el servidor.';
            }
        } else {
            $errores[] = 'Tipo de archivo no permitido. Solo se permiten imágenes JPG, JPEG, PNG y GIF.';
        }
    } elseif (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        $errores[] = 'Error al subir la imagen.';
    }

  
    if (empty($errores)) {
        require_once '../../modelo/articulo/insertarArticulo.php';
        $usuario_id=  $_SESSION['usuario_id'];
        $resultado = insertarArticulo($titulo, $contenido, $rutaImagenBD, $usuario_id);

        if ($resultado === true) {
            require_once '../../controlador/errores/errores.php';
            $correcto = Mensajes::EXITO_INSERTAR_ARTICULO;
        } else {
            $errores[] = 'Error al insertar el artículo en la base de datos.';
        }
    }

    return [$errores, $correcto];
}
}
