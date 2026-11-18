<?php
// Este es el único archivo por el que se entra a la web.
// Todas las direcciones son del tipo index.php?pagina=algo, y según lo que venga
// en "pagina" decido qué vista cargo. Así tengo todo controlado desde un mismo sitio
// y no hay archivos sueltos a los que se pueda entrar directamente.

session_start();

require_once __DIR__ . '/config/database.php';

// Si no me dicen ninguna página, enseño el inicio
$pagina = $_GET['pagina'] ?? 'inicio';

// En $titulo guardo el texto que sale en la pestaña del navegador,
// y la cabecera lo usa para montar el <title>
switch ($pagina) {

    case 'inicio':
        $titulo = 'Inicio';
        include __DIR__ . '/views/inicio.php';
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
