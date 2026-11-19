<?php
// Modelo de usuarios. Aquí meto todas las consultas que tocan la tabla usuarios,
// así el resto del código no tiene que saber nada de SQL.
// Uso métodos estáticos porque no necesito crear objetos Usuario, solo llamar
// a las funciones, por ejemplo Usuario::crear(...).

require_once __DIR__ . '/../config/database.php';

class Usuario {

    // Busco un usuario por su email. Lo uso en el login para sacar su contraseña
    // cifrada y su rol. Si no existe, fetch() me devuelve false.
    public static function buscarPorEmail($email) {
        $pdo = obtenerConexion();
        $sql = 'SELECT * FROM usuarios WHERE email = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Busco un usuario por su id, para enseñar los datos de su cuenta en el panel
    public static function buscarPorId($id) {
        $pdo = obtenerConexion();
        $sql = 'SELECT id, nombre, email, rol, fecha_registro FROM usuarios WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Compruebo si ya hay alguien registrado con ese email, para no repetirlo.
    // Uso consultas preparadas con ? en vez de meter la variable en el SQL,
    // así nadie puede colar código SQL escribiendo cosas raras en el formulario.
    public static function existeEmail($email) {
        $pdo = obtenerConexion();
        $sql = 'SELECT COUNT(*) AS total FROM usuarios WHERE email = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $fila = $stmt->fetch();
        return $fila['total'] > 0;
    }

    // Guardo un usuario nuevo. La contraseña me llega ya cifrada desde el controlador.
    // Todos los que se registran desde la web entran como usuario normal,
    // los admin solo se pueden crear directamente en la base de datos.
    public static function crear($nombre, $email, $passwordCifrada) {
        $pdo = obtenerConexion();
        $sql = 'INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $email, $passwordCifrada, 'usuario']);
        return $pdo->lastInsertId();
    }
}
