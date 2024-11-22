
<?php
function iniciarSesionController($nombre_usuario, $password)
{
    $errores = [];
    session_start();

    // Inicializa intentos de inicio de sesión
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Validación de la contraseña
        require_once "validarPassword.php";
        $password_ok = comprobarPassword($password);

        if ($password_ok === true) {
            require_once "../../modelo/user/iniciarSesion.php";
            $errores = iniciarSesion($nombre_usuario, $password);

            if (empty($errores)) {
                // Verificar si el usuario seleccionó "Recordar"
                if (isset($_POST['recordar']) && $_POST['recordar'] === 'on') {
                    // Generar un token seguro
                    $token = bin2hex(random_bytes(32)); // 32 bytes = 64 caracteres hexadecimales

                    require_once "../../modelo/user/tokenInicioSesion.php";
                    almacenarTokenEnBD($nombre_usuario, $token); // Almacenar token en la base de datos

                    // Guardar el token y el nombre de usuario en cookies
                    setcookie('token', $token, time() + (30 * 24 * 60 * 60), "/"); // 30 días
                    setcookie('nombre_usuario', $nombre_usuario, time() + (30 * 24 * 60 * 60), "/");
                }

                return true; // Inicio de sesión exitoso
            } else {
                $errores[] = 'Credenciales inválidas.';
            }
        } else {
            $_SESSION['login_attempts']++;

            if ($_SESSION['login_attempts'] >= 3) {
                // Validar reCAPTCHA
                if (!isset($_POST['g-recaptcha-response'])) {
                    $errores[] = 'Por favor, completa el reCAPTCHA.';
                } else {
                    $recaptcha_secret = 'TU_SECRET_KEY';
                    $recaptcha_response = $_POST['g-recaptcha-response'];
                    $recaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
                    $recaptcha = json_decode($recaptcha);
    
                    if (!$recaptcha->success) {
                        $errores[] = 'La verificación de reCAPTCHA ha fallado. Inténtalo de nuevo.';
                    }
                }
            }

            $errores[] = ErroresPassword::CONTRASEÑA_INCORRECTA;
        }
    }

    return $errores;
}
