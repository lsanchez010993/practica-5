<?php
function iniciarSesionController($nombre_usuario, $password)
{


    $errores = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Validación de la contraseña. Antes de hacer la conexión a la base de datos, compruebo si el password cumple los requisitos.
        require_once "validarPassword.php";
        $password_ok = comprobarPassword($password);


        if ($password_ok === true) {


            require_once "../../modelo/user/iniciarSesion.php";
            $errores = iniciarSesion($nombre_usuario, $password);



            if (empty($errores)) {
                // Verificar si el usuario seleccionó la opción "Recordar"
                if (isset($_POST['recordar']) && $_POST['recordar'] === 'on') {
                    // Generar un token seguro
                    $token = bin2hex(random_bytes(32)); // 32 bytes = 64 caracteres hexadecimales
                    var_dump($token);
                    
                    require_once "../../modelo/user/tokenInicioSesion.php";

                    almacenarTokenEnBD($nombre_usuario, $token); // Función que almacena el token en la base de datos

                    // Guardar el token en una cookie
                    setcookie('token', $token, time() + (30 * 24 * 60 * 60), "/"); // La cookie expira en 30 días
                    setcookie('nombre_usuario', $nombre_usuario, time() + (30 * 24 * 60 * 60), "/");
                }

                return true; // Inicio de sesión exitoso
            } else {
                $errores[] = 'Credenciales inválidas.';
            }
        } else {
            $errores[] = ErroresPassword::CONTRASEÑA_INCORRECTA;
        }
    }

    return $errores;
}
