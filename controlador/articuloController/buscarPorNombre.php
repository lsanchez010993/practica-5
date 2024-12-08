
<?php
require_once __DIR__. "../../..//modelo/articulo/obtenerAnimalPor_Id.php";
if (isset($_GET['nombre_comun'])) {
    $nombre_comun = $_GET['nombre_comun']; // Recibir el parámetro por GET
    $resultadosBusqueda = obtenerAnimalPorNombre($nombre_comun); // Llamar la función con el parámetro
  

}
include __DIR__ . '../../../index.php';
// require_once __DIR__ . '../../../vista/animal/vistaAnimales.php';


?>
