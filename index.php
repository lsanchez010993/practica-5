<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>
    <link rel="stylesheet" href="vista/estils/estils_Index.css">
</head>

<body>
    <?php
    
    session_start();

    if (!isset($_SESSION['nombre_usuario'])) {
        // El usuario no ha iniciado sesión
       
        
  
      
        echo <<<HTML
        <div class="inicio">
         <button onclick="location.href='vista/usuaris/inicioSesion.form.php'">Iniciar Sesión</button>
         <button onclick="location.href='vista/usuaris/crearUsuario.php'">Registrarse</button>
         </div> 
HTML;
        include_once 'vista/articles/vistaArticulos.php';
    } else {
        $nombre = $_SESSION['nombre_usuario'];
       
        echo <<<HTML
    <div class="inicio">
    <h2>Bienvenido: $nombre </h2>;
    <button onclick="location.href='vista/articles/insertarNuevoArticulo.php'">Insertar Nuevo Articulo</button>
    <button onclick="location.href='modelo/user/cerrarSesion.php'">Cerrar Sesión</button>

  </div> 
HTML;
        // Si el usuario ha iniciado sesión, mostrar artículos solo del usuario
        include_once 'vista/articles/vistaArticulos.php';
    }
    ?>
</body>

</html>