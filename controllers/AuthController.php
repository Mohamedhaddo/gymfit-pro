<?php
// Controlador de todo lo relacionado con las cuentas de usuario.
// Los controladores solo reciben los datos de los formularios, los comprueban
// y redirigen a otra página. No pintan nada de HTML. Lo hago así para que si el
// usuario recarga la página después de enviar el formulario no se envíe dos veces.

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    // Proceso el formulario de registro
    public static function registro() {
        // Si alguien entra a esta dirección sin enviar el formulario lo devuelvo al registro
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?pagina=registro');
            exit;
        }

        // Recojo los datos y les quito los espacios del principio y del final
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        // Aunque el formulario ya se valida en el navegador con HTML5, vuelvo a comprobarlo
        // todo aquí, porque desde el navegador se puede saltar la validación muy fácil
        // (por ejemplo quitando el required con las herramientas de desarrollador).
        $error = '';

        if ($nombre === '' || $email === '' || $password === '' || $password2 === '') {
            $error = 'Tienes que rellenar todos los campos.';
        }
        // El nombre solo puede llevar letras (también con tilde y ñ) y espacios.
        // La u del final hace que PHP entienda bien los caracteres con tilde.
        // Referencia: https://www.php.net/manual/es/reference.pcre.pattern.modifiers.php
        elseif (!preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ ]{2,100}$/u', $nombre)) {
            $error = 'El nombre solo puede tener letras y espacios, con un mínimo de 2.';
        }
        // Para el email uso el filtro que ya trae PHP para comprobarlos.
        // Referencia: https://www.php.net/manual/es/function.filter-var.php
        elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error = 'El email no tiene un formato válido.';
        }
        // La contraseña tiene que tener 8 caracteres como mínimo, una mayúscula y un número.
        // Los (?=...) comprueban que haya al menos una mayúscula y un número en cualquier
        // posición, y el .{8,} que la longitud total sea de 8 o más.
        elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $error = 'La contraseña necesita al menos 8 caracteres, una mayúscula y un número.';
        }
        elseif ($password !== $password2) {
            $error = 'Las dos contraseñas no coinciden.';
        }
        elseif (Usuario::existeEmail($email)) {
            $error = 'Ya hay una cuenta registrada con ese email.';
        }

        // Si algo ha fallado vuelvo al formulario con el mensaje de error
        if ($error !== '') {
            $_SESSION['mensaje'] = $error;
            $_SESSION['mensaje_tipo'] = 'error';
            header('Location: index.php?pagina=registro');
            exit;
        }

        // Cifro la contraseña antes de guardarla, nunca la guardo tal cual la escribe el usuario.
        // Referencia: https://www.php.net/manual/es/function.password-hash.php
        $passwordCifrada = password_hash($password, PASSWORD_DEFAULT);
        Usuario::crear($nombre, $email, $passwordCifrada);

        $_SESSION['mensaje'] = 'Tu cuenta se ha creado correctamente.';
        $_SESSION['mensaje_tipo'] = 'exito';
        header('Location: index.php?pagina=inicio');
        exit;
    }
}
