<?php
// controlador/animalController.php
require_once __DIR__ . '../../../modelo/articulo/ordenacionAnimales.php';

function obtenerAnimalesConOrden($start, $articulosPorPagina, $orden) {
    // Configurar el orden basado en la opción seleccionada
    switch ($orden) {
        case 'nombre_asc':
            $columnaOrden = 'nombre_comun';
            $direccionOrden = 'ASC';
            break;
        case 'nombre_desc':
            $columnaOrden = 'nombre_comun';
            $direccionOrden = 'DESC';
            break;
        case 'tipo_mamifero':
            $columnaOrden = 'es_mamifero';
            $direccionOrden = 'DESC'; // Mamíferos primero (1)
            break;
        case 'tipo_oviparo':
            $columnaOrden = 'es_mamifero';
            $direccionOrden = 'ASC'; // Ovíparos primero (0)
            break;
        default:
            $columnaOrden = 'nombre_comun';
            $direccionOrden = 'ASC';
    }

    // Llamar al modelo con los parámetros establecidos
    return obtenerAnimalesDesdeModelo($start, $articulosPorPagina, $columnaOrden, $direccionOrden);
}
?>