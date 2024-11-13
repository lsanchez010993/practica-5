<?php
require_once 'controlador/errores/errores.php';
?>
<script>
    function confirmarEliminacion() {
        return confirm("<?php echo Mensajes::CONFIRMAR_ACTUALIZACION ?>");
    }
</script>
<?php

// Función para listar los artículos y centrarlos en la página
function listarArticulos($animales, $accion = null, $paginaActual = 1, $totalPaginas = 1)
{
    // Verificar si hay artículos y mostrarlos
    if (!empty($animales)) {
        if ($accion == 'editar') {
            echo "<h1>Mis artículos</h1>";
        } else {
            echo '<h1>Todos los artículos</h1>';
        }

        // Iniciar el contenedor de tarjetas
        echo '<div class="contenedor-tarjetas">';

        foreach ($animales as $animal) {
            echo '<div class="tarjeta">';
            echo '<h2> <strong class="nombre_comun">Nombre comun: </strong>' . htmlspecialchars($animal['nombre_comun']) . ' </h2>';
            echo '<h3> <span class="nombre_cientifico">Nombre cientifico:<spn> ' . htmlspecialchars($animal['nombre_cientifico']) . '</h3>';

            // Verificar y mostrar la imagen del animal si está presente
            if (!empty($animal['ruta_imagen'])) {
                echo '<img src="' . htmlspecialchars('vista/' . $animal['ruta_imagen']) . '" alt="Imagen del artículo" class="tarjeta-imagen">';
            }

            echo '<p class="descripcion">' . htmlspecialchars($animal['descripcion']) . '</p>';


            // Opciones de edición si corresponde
            if ($accion == 'editar') {
                echo "<a href='modelo/articulo/eliminarAnimal.php?id=" . $animal['id'] . "' onclick='return confirmarEliminacion()'>
                        <img src='./vista/imagenes/iconos/eliminar.png' alt='Eliminar' width='20' height='20'>
                      </a>";

                echo "<a href='./vista/animal/modificarAnimal.vista.php?id=" . $animal['id'] . "'>
                        <img src='./vista/imagenes/iconos/editar.png' alt='Editar' width='20' height='20'>
                      </a>";
            }

            echo '</div>'; // Cierra el div de la tarjeta
        }

        echo '</div>';

     
        if ($totalPaginas > 1) {
            echo '<div class="paginacio">';
            echo '<ul>';

            // Botón "Anterior"
            if ($paginaActual > 1) {
                $paginaAnterior = $paginaActual - 1;
                echo '<li><a href="?pagina=' . $paginaAnterior . '">&laquo; Anterior</a></li>';
            } else {
                echo '<li class="disabled"><span>&laquo; Anterior</span></li>';
            }

            // Números de página
            for ($i = 1; $i <= $totalPaginas; $i++) {
                if ($i == $paginaActual) {
                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                } else {
                    echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
                }
            }

            // Botón "Siguiente"
            if ($paginaActual < $totalPaginas) {
                $paginaSiguiente = $paginaActual + 1;
                echo '<li><a href="?pagina=' . $paginaSiguiente . '">Siguiente &raquo;</a></li>';
            } else {
                echo '<li class="disabled"><span>Siguiente &raquo;</span></li>';
            }

            echo '</ul>';
            echo '</div>';
        }
    } else {
        echo Mensajes::NO_ANIMALES;
    }
}
?>
