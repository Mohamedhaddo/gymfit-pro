<?php
include __DIR__ . '/../layout/header.php';

// Saco los datos de la cuenta del usuario que ha hecho login
$usuario = Usuario::buscarPorId($_SESSION['usuario_id']);
?>

<section class="bloque">
    <h2>Mi panel</h2>

    <!-- De momento solo enseño los datos de la cuenta. Las reservas las añadiré
         en este mismo panel cuando haga la parte de las actividades -->
    <article class="tarjeta">
        <h3>Mi cuenta</h3>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <p><strong>Socio desde:</strong> <?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></p>
    </article>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
