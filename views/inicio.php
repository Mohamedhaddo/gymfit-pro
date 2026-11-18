<?php include __DIR__ . '/layout/header.php'; ?>

<!-- Parte de arriba de la portada, con el mensaje principal tal y como lo dibujé en el prototipo -->
<section class="portada">
    <h1>Entrena. Reserva. Supera tus límites.</h1>
    <p>Gestiona tus clases dirigidas online y olvídate de las colas en recepción.</p>
    <a href="index.php?pagina=actividades" class="boton">Ver actividades</a>
</section>

<!-- Cuatro tarjetas que explican lo que ofrece la web. Uso article porque cada
     tarjeta tiene sentido por sí sola -->
<section class="bloque">
    <h2>¿Por qué GymFit Pro?</h2>

    <div class="rejilla-tarjetas">
        <article class="tarjeta">
            <h3>Aforo en tiempo real</h3>
            <p>Ves al momento cuántas plazas quedan en cada clase, sin overbooking.</p>
        </article>

        <article class="tarjeta">
            <h3>Reserva en dos clics</h3>
            <p>Reserva tu plaza desde el móvil o el ordenador en unos segundos.</p>
        </article>

        <article class="tarjeta">
            <h3>Cancela con margen</h3>
            <p>Si te surge algo, puedes cancelar siempre que falten más de dos horas para la clase.</p>
        </article>

        <article class="tarjeta">
            <h3>Guía de ejercicios</h3>
            <p>Ejercicios organizados por grupo muscular, con instrucciones paso a paso.</p>
        </article>
    </div>
</section>

<!-- Franja final para animar a la gente a crearse una cuenta -->
<section class="bloque bloque-cta">
    <h2>Empieza hoy mismo</h2>
    <p>Crea tu cuenta gratis y reserva tu primera clase.</p>
    <a href="index.php?pagina=registro" class="boton">Crear cuenta</a>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>
