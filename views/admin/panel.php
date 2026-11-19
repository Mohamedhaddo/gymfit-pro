<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="bloque">
    <h2>Panel de administración</h2>
    <p>Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>. Desde aquí se gestiona todo el gimnasio.</p>

    <!-- Esta página solo la puede ver un admin, lo controlo en el index.php.
         Aquí iré añadiendo la gestión de actividades, ejercicios, reservas y usuarios -->
    <p>Pronto podrás gestionar desde aquí las actividades, los ejercicios, las reservas y los usuarios.</p>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
