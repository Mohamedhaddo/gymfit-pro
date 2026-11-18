<?php
// Cabecera común de todas las páginas. Cada vista la incluye al principio
// y así no tengo que repetir el menú ni el <head> en cada archivo.

// Si por lo que sea no hay sesión iniciada la arranco, para poder
// comprobar más adelante si el usuario ha hecho login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo ?? 'GymFit Pro'); ?> | GymFit Pro</title>
</head>
<body>
    <header class="cabecera">
        <a href="index.php?pagina=inicio" class="logo">Gym<span>Fit</span> Pro</a>

        <nav class="menu-principal">
            <a href="index.php?pagina=inicio">Inicio</a>
            <a href="index.php?pagina=actividades">Actividades</a>
            <a href="index.php?pagina=ejercicios">Guía de ejercicios</a>
            <a href="index.php?pagina=guia_estilo">Guía de estilo</a>
            <a href="index.php?pagina=login">Entrar</a>
            <a href="index.php?pagina=registro">Registrarse</a>
        </nav>
    </header>

    <main class="contenido">
