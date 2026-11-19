<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="bloque bloque-estrecho">
    <h2>Iniciar sesión</h2>

    <!-- Igual que en el registro, el navegador valida con HTML5 que los dos campos
         estén rellenos y que el email tenga un formato correcto antes de enviarlo -->
    <form action="index.php?pagina=procesar_login" method="POST" class="formulario">

        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com"
                   required maxlength="150">
        </div>

        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu contraseña"
                   required>
        </div>

        <button type="submit" class="boton">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="index.php?pagina=registro">Regístrate aquí</a>.</p>

    <!-- Dejo a mano los usuarios de prueba para que se pueda probar la web con los dos roles -->
    <aside class="aviso">
        <p><strong>Usuarios de prueba</strong></p>
        <p>Administrador: admin@gymfit.com / Admin1234</p>
        <p>Socio: socio@gymfit.com / Socio1234</p>
    </aside>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
