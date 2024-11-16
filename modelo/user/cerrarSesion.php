<?php
require_once __DIR__ .'/tokenInicioSesion.php';
cerrarSesion();
session_start();
session_unset();
session_destroy();
header("Location: ../../index.php");
exit();
