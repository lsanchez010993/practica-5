<?php
require_once 'controlador/errores/errores.php';
?>
<script>
    function confirmarEliminacion() {
        return confirm("<?php echo Mensajes::CONFIRMAR_ACTUALIZACION ?>");
    }
</script>
<?php

// Utilizo esta función en vistaArticulos. Si la acción que se le pasa a 'listarArticulos()' es 'editar', agrega las opciones de editar junto a cada artículo.
// De otra forma, estas permanecen ocultas.
function listarArticulos($articles, $accion = null)
{
    // Verificar si hay artículos y mostrarlos
    if (!empty($articles)) {
        if ($accion == 'editar') {
            echo "<h1>Mis artículos</h1>";
        } else {
            echo '<h1>Todos los artículos</h1>';
        }

        foreach ($articles as $article) {
            echo '<div class="tarjeta">';
            echo '<h2>' . htmlspecialchars($article['titol']) . '</h2>';
        
            if (!empty($article['ruta_imagen'])) {
            
                echo '<img src="' . htmlspecialchars('vista/'.$article['ruta_imagen']) . '" alt="Imagen del artículo" class="tarjeta-imagen">';
            }
        
            echo '<p>' . htmlspecialchars($article['cos']) . '</p>';
        
            // Opciones de edición si corresponde
            if ($accion == 'editar') {
                echo "<a href='modelo/articulo/eliminarArticulo.php?id=" . $article['id'] . "' onclick='return confirmarEliminacion()'>
                        <img src='./vista/imagenes/iconos/eliminar.png' alt='Eliminar' width='20' height='20'>
                      </a>";
        
                echo "<a href='./vista/articles/modificarArticulo.vista.php?id=" . $article['id'] . "'>
                        <img src='./vista/imagenes/iconos/editar.png' alt='Editar' width='20' height='20'>
                      </a>";
            }
        
            echo '</div>'; // Cierra el div de la tarjeta
        }
        
        
    } else {
        echo Mensajes::NO_ARTICULOS;
    }
}
?>
