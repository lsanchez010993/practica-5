<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Menú principal</title>
</head>

<body>
    <div class="contenidor">

        <section class="articles">
            <ul>
                <?php
                // Iniciar la sesión si no está iniciada
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Verificar si el usuario ha iniciado sesión y controlar la sesión
                if (isset($_SESSION['nombre_usuario'])) {
                    $nombre_usuario = $_SESSION['nombre_usuario'];
                    require_once __DIR__ . '../../../controlador/userController/verificarSesion.php';
                    verificarSesion();
                }

                require_once __DIR__ . '../../../modelo/conexion.php';
                require_once 'modelo/articulo/contarAnimal.php';

                // Obtener el número de artículos por página seleccionado por el usuario y almacenarlo en una cookie
                if (isset($_GET['posts_per_page'])) {
                    $articulosPorPagina = (int)$_GET['posts_per_page'];
                    setcookie('posts_per_page', $articulosPorPagina, time() + (86400 * 30), "/"); // La cookie expira en 30 días
                } elseif (isset($_COOKIE['posts_per_page'])) {
                    $articulosPorPagina = (int)$_COOKIE['posts_per_page'];
                } else {
                    $articulosPorPagina = 6; // Valor por defecto de 6
                }

                $totalArticulos = contarArticulos();

                // Calcular el número total de páginas
                $totalPaginas = ceil($totalArticulos / $articulosPorPagina);

                // Obtener la página actual y almacenarla en una cookie
                if (isset($_GET['page'])) {
                    $pagina = (int)$_GET['page'];
                    setcookie('current_page', $pagina, time() + (86400 * 30), "/"); // La cookie expira en 30 días
                } elseif (isset($_COOKIE['current_page'])) {
                    $pagina = (int)$_COOKIE['current_page'];
                } else {
                    $pagina = 1;
                }

                if ($pagina < 1 || $pagina > $totalPaginas) {
                    $pagina = 1;
                }

                // Calcular desde qué artículo iniciar
                $start = ($pagina > 1) ? ($pagina * $articulosPorPagina) - $articulosPorPagina : 0;

                require_once 'modelo/articulo/limit_animales_por_pagina.php';

                // Obtener el ID del usuario si ha iniciado sesión
                $user_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

                // Listar los artículos según el usuario
                if (isset($user_id) && $user_id != null) {
                    $articles = limit_articulos_por_pagina($start, $articulosPorPagina, $user_id);
                    require_once 'vista/animal/Mostrar.php';
                    listarArticulos($articles, 'editar');
                } else {
                    $articles = limit_articulos_por_pagina($start, $articulosPorPagina);
                    require_once 'vista/animal/Mostrar.php';
                    listarArticulos($articles);
                }
                ?>
            </ul>
        </section>
     
        <!-- Menú desplegable para seleccionar el número de artículos por página -->
        <div class="posts-per-page">
            <form method="GET" action="">
                <label for="posts_per_page">Artículos por página:</label>
                <select name="posts_per_page" id="posts_per_page" onchange="this.form.submit()">
                    <option value="6" <?php if ($articulosPorPagina == 6) echo 'selected'; ?>>6</option>
                    <option value="12" <?php if ($articulosPorPagina == 12) echo 'selected'; ?>>12</option>
                    <option value="16" <?php if ($articulosPorPagina == 16) echo 'selected'; ?>>16</option>
                </select>
                <!-- Mantener la página actual al cambiar el número de artículos por página -->
                <input type="hidden" name="page" value="<?php echo $pagina; ?>">
            </form>
        </div>

        <section class="paginacio">
            <ul>
                <?php
                require_once 'modelo/articulo/contarAnimal.php';
                $totalArticles = contarArticulos($user_id);

                $totalPages = ceil($totalArticles / $articulosPorPagina);

                // Parámetros adicionales para mantener en los enlaces
                $additionalParams = '&posts_per_page=' . $articulosPorPagina;

                // Botón "Anterior"
                if ($pagina > 1) {
                    echo '<li><a href="?page=' . ($pagina - 1) . $additionalParams . '">&laquo;</a></li>';
                } else {
                    echo '<li class="disabled"><a href="#">&laquo;</a></li>';
                }

                // Enlaces de páginas
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($pagina == $i) {
                        echo '<li class="active"><a href="?page=' . $i . $additionalParams . '">' . $i . '</a></li>';
                    } else {
                        echo '<li><a href="?page=' . $i . $additionalParams . '">' . $i . '</a></li>';
                    }
                }

                // Botón "Siguiente"
                if ($pagina < $totalPages) {
                    echo '<li><a href="?page=' . ($pagina + 1) . $additionalParams . '">&raquo;</a></li>';
                } else {
                    echo '<li class="disabled"><a href="#">&raquo;</a></li>';
                }
                ?>
            </ul>
        </section>





    </div>
</body>

</html>