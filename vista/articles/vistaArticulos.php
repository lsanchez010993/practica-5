<?php
// He definido una constante para que resulte más facil modificar el numero de artículos que debe mostrarse por página
const ARTICULOS_POR_PAGINA = 5; //Esta opcion se le podria preguntar al usuario. Iconos que muestren 5, 10 15 articulos por pagina
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>
</head>

<body>
    <div class="contenidor">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <section class="articles">
            <ul>
                <?php
                //Si el usuario ha iniciado sesion... verificarSesion() controla el tiempo que estara abierta la sesion
                if (isset($_SESSION['nombre_usuario'])) {

                    $nombre_usuario = $_SESSION['nombre_usuario'];
                    require_once __DIR__ . '../../../controlador/userController/verificarSesion.php';
                    verificarSesion();
                }

                // Establecer la página actual
               
                require_once __DIR__ . '../../../modelo/conexion.php';
                require_once 'modelo/articulo/contarArticulos.php';
                // Número total de artículos (puedes obtener esto de tu base de datos)
                $totalArticulos = contarArticulos(); // Asume que obtienes el total de artículos desde la base de datos

                // Calcula el número total de páginas
                $totalPaginas = ceil($totalArticulos / ARTICULOS_POR_PAGINA);

                // Obtiene el número de página de la URL. Si no existe, por defecto es 1
                $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                // Si la página solicitada es menor que 1 o mayor que el total de páginas
                if ($pagina < 1 || $pagina > $totalPaginas) {
                    // Redirige a la primera página
                    $pagina = 1;
                }

                // Código para cargar los artículos de la página $pagina


                // Definir el número de artículos por página


                // Calcular desde qué artículo iniciar
                $start = ($pagina > 1) ? ($pagina * ARTICULOS_POR_PAGINA) - ARTICULOS_POR_PAGINA : 0;

                require_once 'modelo/articulo/limit_articulos_por_pagina.php';
                //compruebo si el usuario ha iniciado sesion. Si la ha iniciado guardo su user_id.
                $user_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;

                //Listo solo los articulos de un usuario
                if (isset($user_id) && $user_id != null) {
                    $articles = limit_articulos_por_pagina($start, ARTICULOS_POR_PAGINA, $user_id);
                    // Mostrar los artículos del usuario
                    require_once 'vista/articles/Mostrar.php';
                    listarArticulos($articles, 'editar');
                    //Listo todos los articulos:
                } else {
                    $articles = limit_articulos_por_pagina($start, ARTICULOS_POR_PAGINA);
                    // Mostrar todos los artículos
                    require_once 'vista/articles/Mostrar.php';
                    listarArticulos($articles);
                }
                ?>
            </ul>
        </section>

        <section class="paginacio">
            <ul>
                <?php
                // Consulta para contar el número total de artículos
                require_once 'modelo/articulo/contarArticulos.php';
                $totalArticles = contarArticulos($user_id);

                // Calcular el número total de páginas
                $totalPages = ceil($totalArticles / ARTICULOS_POR_PAGINA);
                // Botón "Anterior"
                if ($pagina > 1) {
                    echo '<li><a href="?page=' . ($pagina - 1) . '">&laquo;</a></li>';
                } else {
                    echo '<li class="disabled"><a href="#">&laquo;</a></li>';
                }
                // Generar los enlaces para cada página
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($pagina == $i) {
                        echo '<li class="active"><a href="?page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                    }
                }
                // Botón "Siguiente"
                if ($pagina < $totalPages) {
                    echo '<li><a href="?page=' . ($pagina + 1) . '">&raquo;</a></li>';
                } else {
                    echo '<li class="disabled"><a href="#">&raquo;</a></li>';
                }
                ?>
            </ul>
        </section>
    </div>
</body>

</html>