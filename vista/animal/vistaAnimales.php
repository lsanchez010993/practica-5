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
                    $user_id = $_SESSION['usuario_id'];
                    require_once __DIR__ . '../../../controlador/userController/verificarSesion.php';
                    verificarSesion();
                } else {
                    $user_id = null;
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

                // Obtener el criterio de ordenación
                $orden = isset($_GET['orden']) ? $_GET['orden'] : 'nombre'; // Por defecto, ordenar por nombre

                require_once __DIR__ . '../../../controlador/articuloController/ordenarPorTipo.php';

                // Obtener los parámetros de entrada
                $orden = $_GET['orden'] ?? 'nombre_asc';
                $pagina = $_GET['page'] ?? 1;
                $articulosPorPagina = $_GET['posts_per_page'] ?? 6;

                // Calcular el inicio
                $start = ($pagina > 1) ? ($pagina * $articulosPorPagina) - $articulosPorPagina : 0;

                // Obtener los animales con el orden seleccionado
                // $animales = obtenerAnimalesConOrden($start, $articulosPorPagina, $orden);
                // Llamar a la función para obtener los artículos con orden y límite
                require_once 'modelo/articulo/limit_animales_por_pagina.php';

                if (isset($user_id) && $user_id != null) {
                    $articles = obtenerAnimalesConOrden($start, $articulosPorPagina, $orden);
                    require_once 'vista/animal/Mostrar.php';
                    listarArticulos($articles, 'editar');
                } else {
                    $articles = obtenerAnimalesConOrden($start, $articulosPorPagina, $orden);
                    require_once 'vista/animal/Mostrar.php';
                    listarArticulos($articles);
                }

                ?>
            </ul>
        </section>
        <!-- Menú desplegable para ordenar los artículos -->
        <div class="desplegable">
            <form method="GET" action="">
                <label for="orden">Ordenar por:</label>
                <select name="orden" id="orden" onchange="this.form.submit()">
                    <option value="nombre_asc" <?php if (isset($_GET['orden']) && $_GET['orden'] == 'nombre_asc') echo 'selected'; ?>>Nombre (Ascendente)</option>
                    <option value="nombre_desc" <?php if (isset($_GET['orden']) && $_GET['orden'] == 'nombre_desc') echo 'selected'; ?>>Nombre (Descendente)</option>
                    <option value="tipo_mamifero" <?php if (isset($_GET['orden']) && $_GET['orden'] == 'tipo_mamifero') echo 'selected'; ?>>Tipo (Mamíferos primero)</option>
                    <option value="tipo_oviparo" <?php if (isset($_GET['orden']) && $_GET['orden'] == 'tipo_oviparo') echo 'selected'; ?>>Tipo (Ovíparos primero)</option>
                </select>
                <input type="hidden" name="page" value="<?php echo $pagina; ?>">
                <input type="hidden" name="posts_per_page" value="<?php echo $articulosPorPagina; ?>">
            </form>
        </div>

        <div class="desplegable">
            <form method="GET" action="">
                <label for="posts_per_page">Artículos por página:</label>
                <select name="posts_per_page" id="posts_per_page" onchange="this.form.submit()">
                    <option value="6" <?php if ($articulosPorPagina == 6) echo 'selected'; ?>>6</option>
                    <option value="12" <?php if ($articulosPorPagina == 12) echo 'selected'; ?>>12</option>
                    <option value="16" <?php if ($articulosPorPagina == 16) echo 'selected'; ?>>16</option>
                </select>
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