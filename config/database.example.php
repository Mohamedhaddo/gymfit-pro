<?php
// Plantilla de configuración del proyecto.
// El archivo de verdad es database.php, pero ese no lo subo a GitHub porque lleva
// la contraseña de la base de datos. Para instalar el proyecto en otro sitio
// (por ejemplo en el servidor de AWS) basta con copiar este archivo, llamarlo
// database.php y cambiar los datos de conexión.

// Datos para conectarme a MySQL. En XAMPP el usuario es root y no tiene contraseña.
define('DB_HOST', 'localhost');
define('DB_NAME', 'gimnasio_daw');
define('DB_USER', 'root');
define('DB_PASS', '');

// Horas que tienen que faltar como mínimo para poder cancelar una reserva
define('LIMITE_CANCELACION_HORAS', 2);

// Tamaño máximo de las imágenes que se suben, 2 MB pasados a bytes (2 * 1024 * 1024)
define('MAX_TAMANO_IMAGEN', 2097152);

// Carpeta donde se guardan las imágenes de las actividades
define('RUTA_UPLOADS', __DIR__ . '/../public/uploads/actividades/');

// Esta función me devuelve una conexión nueva a la base de datos cada vez que la llamo.
// Le paso tres opciones a PDO:
// ERRMODE_EXCEPTION para que si falla una consulta salte una excepción y me entere,
// FETCH_ASSOC para que los resultados me lleguen como array con el nombre de las columnas,
// y EMULATE_PREPARES a false para que las consultas preparadas las haga MySQL de verdad
// y no PDO por su cuenta.
// Referencia: https://www.php.net/manual/es/pdo.setattribute.php
function obtenerConexion() {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    try {
        return new PDO($dsn, DB_USER, DB_PASS, $opciones);
    } catch (PDOException $e) {
        // Si no puedo conectar no tiene sentido seguir, así que paro aquí
        die('No se ha podido conectar con la base de datos: ' . $e->getMessage());
    }
}
