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

            <?php // El final del menú cambia según si hay alguien conectado y según su rol ?>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <?php if ($_SESSION['usuario_rol'] === 'admin'): ?>
                    <a href="index.php?pagina=admin">Panel admin</a>
                <?php else: ?>
                    <a href="index.php?pagina=panel">Mi panel</a>
                <?php endif; ?>
                <a href="index.php?pagina=logout">Cerrar sesión</a>
            <?php else: ?>
                <a href="index.php?pagina=login">Entrar</a>
                <a href="index.php?pagina=registro">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php
    // Mensajes de aviso. Cuando un controlador termina (por ejemplo al registrarse)
    // deja un mensaje en la sesión antes de redirigir. Aquí lo enseño y lo borro
    // en el momento con unset(), para que no vuelva a salir al recargar la página.
    if (isset($_SESSION['mensaje'])):
        $tipoMensaje = $_SESSION['mensaje_tipo'] ?? 'exito';
    ?>
        <div class="mensaje mensaje-<?php echo htmlspecialchars($tipoMensaje); ?>">
            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['mensaje_tipo']);
    endif;
    ?>

    <main class="contenido">
