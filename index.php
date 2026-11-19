<?php
// Este es el único archivo por el que se entra a la web.
// Todas las direcciones son del tipo index.php?pagina=algo, y según lo que venga
// en "pagina" decido qué vista cargo. Así tengo todo controlado desde un mismo sitio
// y no hay archivos sueltos a los que se pueda entrar directamente.

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Usuario.php';

// Unas funciones pequeñas para controlar quién puede entrar a cada página.
// Las uso antes de cargar las vistas privadas.

// Devuelve true si hay alguien que ha hecho login
function haySesion() {
    return isset($_SESSION['usuario_id']);
}

// Devuelve true si el que ha hecho login es administrador
function esAdmin() {
    return haySesion() && $_SESSION['usuario_rol'] === 'admin';
}

// Si no hay nadie con sesión iniciada, lo mando al login y corto la ejecución
function exigirSesion() {
    if (!haySesion()) {
        $_SESSION['mensaje'] = 'Tienes que iniciar sesión para ver esa página.';
        $_SESSION['mensaje_tipo'] = 'error';
        header('Location: index.php?pagina=login');
        exit;
    }
}

// Si el que intenta entrar no es admin, lo devuelvo al inicio.
// Primero compruebo que haya sesión, porque si no ni siquiera sé quién es.
function exigirAdmin() {
    exigirSesion();
    if (!esAdmin()) {
        $_SESSION['mensaje'] = 'No tienes permiso para entrar en esa zona.';
        $_SESSION['mensaje_tipo'] = 'error';
        header('Location: index.php?pagina=inicio');
        exit;
    }
}

// Si no me dicen ninguna página, enseño el inicio
$pagina = $_GET['pagina'] ?? 'inicio';

// En $titulo guardo el texto que sale en la pestaña del navegador,
// y la cabecera lo usa para montar el <title>
switch ($pagina) {

    case 'inicio':
        $titulo = 'Inicio';
        include __DIR__ . '/views/inicio.php';
        break;

    case 'registro':
        $titulo = 'Crear cuenta';
        include __DIR__ . '/views/auth/registro.php';
        break;

    // Aquí llega el formulario de registro. No enseño ninguna vista, el controlador
    // procesa los datos y redirige él mismo a la página que toque
    case 'procesar_registro':
        require_once __DIR__ . '/controllers/AuthController.php';
        AuthController::registro();
        break;

    case 'login':
        $titulo = 'Iniciar sesión';
        include __DIR__ . '/views/auth/login.php';
        break;

    case 'procesar_login':
        require_once __DIR__ . '/controllers/AuthController.php';
        AuthController::login();
        break;

    case 'logout':
        require_once __DIR__ . '/controllers/AuthController.php';
        AuthController::logout();
        break;

    // Zona del socio, hace falta haber iniciado sesión
    case 'panel':
        exigirSesion();
        $titulo = 'Mi panel';
        include __DIR__ . '/views/usuario/panel.php';
        break;

    // Zona del administrador, hace falta sesión y además rol de admin
    case 'admin':
        exigirAdmin();
        $titulo = 'Panel de administración';
        include __DIR__ . '/views/admin/panel.php';
        break;

    // Cualquier página que no exista cae aquí. Además de enseñar la página de error,
    // le digo al navegador que es un error 404 con http_response_code().
    // Referencia: https://www.php.net/manual/es/function.http-response-code.php
    default:
        http_response_code(404);
        $titulo = 'Página no encontrada';
        include __DIR__ . '/views/404.php';
        break;
}
