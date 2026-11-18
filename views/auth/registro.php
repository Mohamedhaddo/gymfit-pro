<?php include __DIR__ . '/../layout/header.php'; ?>

<section class="bloque bloque-estrecho">
    <h2>Crear cuenta</h2>
    <p>Regístrate para poder reservar tu plaza en las clases.</p>

    <!-- El formulario se valida con los atributos de HTML5 antes de enviarse.
         required obliga a rellenar el campo, type="email" comprueba que tenga forma de email,
         minlength y maxlength limitan la longitud, y pattern obliga a que el texto
         cumpla una expresión regular. El title es el mensaje que enseña el navegador
         cuando el pattern no se cumple.
         Referencia del atributo pattern: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Attributes/pattern -->
    <form action="index.php?pagina=procesar_registro" method="POST" class="formulario">

        <div class="campo">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu nombre"
                   required minlength="2" maxlength="100"
                   pattern="[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{2,100}"
                   title="Solo letras y espacios, mínimo 2 caracteres">
        </div>

        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com"
                   required maxlength="150">
        </div>

        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres"
                   required minlength="8"
                   pattern="(?=.*[A-Z])(?=.*\d).{8,}"
                   title="Mínimo 8 caracteres, con al menos una mayúscula y un número">
            <small>Al menos 8 caracteres, una mayúscula y un número.</small>
        </div>

        <div class="campo">
            <label for="password2">Repite la contraseña</label>
            <input type="password" id="password2" name="password2" placeholder="Vuelve a escribirla"
                   required minlength="8">
        </div>

        <button type="submit" class="boton">Registrarme</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="index.php?pagina=login">Inicia sesión</a>.</p>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
