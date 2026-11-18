-- Base de datos de GymFit Pro
-- La creo en utf8mb4 para no tener problemas con las tildes y la ñ

CREATE DATABASE IF NOT EXISTS gimnasio_daw
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gimnasio_daw;

-- Si ya existían las tablas las borro para empezar de cero.
-- Primero va reservas porque depende de usuarios y actividades, si no MySQL
-- no me deja borrarlas por las claves foráneas.
DROP TABLE IF EXISTS reservas;
DROP TABLE IF EXISTS ejercicios;
DROP TABLE IF EXISTS actividades;
DROP TABLE IF EXISTS usuarios;

-- Usuarios de la web. El rol solo puede ser usuario o admin, por eso uso ENUM.
-- La contraseña la guardo siempre cifrada, nunca en texto plano, y le dejo 255
-- caracteres porque es lo que recomienda el manual de PHP para password_hash.
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario','admin') DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Clases dirigidas del gimnasio. Cada una se repite un día fijo de la semana.
-- El campo activa me sirve para ocultar una clase sin tener que borrarla.
CREATE TABLE actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    dia_semana ENUM('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    aforo_max INT NOT NULL DEFAULT 20,
    imagen VARCHAR(255) NULL,
    activa TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reservas, que relacionan a un usuario con una actividad.
-- Con el UNIQUE me aseguro de que nadie reserve dos veces la misma clase.
-- Con ON DELETE CASCADE, si borro un usuario o una actividad se borran
-- también sus reservas y no se quedan datos sueltos.
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_actividad INT NOT NULL,
    fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_reserva (id_usuario, id_actividad),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_actividad) REFERENCES actividades(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ejercicios para la guía, que luego se cargan por grupo muscular
CREATE TABLE ejercicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    grupo_muscular VARCHAR(100) NOT NULL,
    dificultad ENUM('Principiante','Intermedio','Avanzado') NOT NULL,
    descripcion TEXT,
    instrucciones TEXT,
    repeticiones_recomendadas VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dos usuarios de prueba, un admin y un socio.
-- admin@gymfit.com con la contraseña Admin1234
-- socio@gymfit.com con la contraseña Socio1234
-- Las contraseñas van cifradas con bcrypt, el mismo formato que genera
-- password_hash() de PHP, para que el login las pueda comprobar con password_verify().
-- Referencia: https://www.php.net/manual/es/function.password-hash.php
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador GymFit', 'admin@gymfit.com', '$2y$10$vQlDioEKsil6Oc9cQ.PL4u3.I9YWq60dt5SKwVuf3KohWDJAUL1pu', 'admin'),
('Carlos Ramírez', 'socio@gymfit.com', '$2y$10$h2Ghqrl.bJgs/lxHCXZ1gecNYRi6ie1t5xWAFh8MwdhokcOToN5xO', 'usuario');

-- Seis actividades repartidas a lo largo de la semana
INSERT INTO actividades (nombre, descripcion, dia_semana, hora_inicio, hora_fin, aforo_max, imagen, activa) VALUES
('Zumba', 'Clase de baile con ritmos latinos para quemar calorías mientras te lo pasas bien.', 'Lunes', '18:00:00', '19:00:00', 25, NULL, 1),
('Spinning', 'Entrenamiento intenso en bicicleta estática guiado por un monitor.', 'Martes', '19:30:00', '20:30:00', 20, NULL, 1),
('Pilates', 'Trabajo de abdomen, flexibilidad y postura con movimientos controlados.', 'Miércoles', '10:00:00', '11:00:00', 15, NULL, 1),
('CrossFit', 'Entrenamiento funcional de alta intensidad que mezcla fuerza y resistencia.', 'Jueves', '20:00:00', '21:00:00', 18, NULL, 1),
('Yoga', 'Sesión de relajación, respiración y estiramientos.', 'Viernes', '09:00:00', '10:00:00', 20, NULL, 1),
('BodyPump', 'Clase con barra y discos para tonificar todo el cuerpo.', 'Sábado', '11:00:00', '12:00:00', 22, NULL, 1);

-- Veinte ejercicios en seis grupos musculares y con los tres niveles de dificultad
INSERT INTO ejercicios (nombre, grupo_muscular, dificultad, descripcion, instrucciones, repeticiones_recomendadas) VALUES
('Press de banca', 'Pecho', 'Intermedio', 'Ejercicio básico para trabajar el pectoral.', 'Túmbate en el banco, baja la barra hasta el pecho controlando y empuja hacia arriba sin bloquear los codos de golpe.', '4 series de 8 a 10'),
('Flexiones', 'Pecho', 'Principiante', 'Ejercicio con el peso del cuerpo para pecho, hombros y tríceps.', 'Pon las manos a la anchura de los hombros, baja con el cuerpo recto hasta casi tocar el suelo y vuelve a subir.', '3 series de 12 a 15'),
('Aperturas con mancuernas', 'Pecho', 'Intermedio', 'Aísla el pectoral con un recorrido amplio.', 'Tumbado, abre los brazos en arco con los codos un poco doblados y júntalos arriba.', '3 series de 12'),
('Press inclinado', 'Pecho', 'Avanzado', 'Trabaja la parte de arriba del pecho.', 'En un banco inclinado entre 30 y 45 grados, empuja la barra desde el pecho hacia arriba.', '4 series de 8'),
('Dominadas', 'Espalda', 'Avanzado', 'Ejercicio completo para dorsales y bíceps.', 'Cuélgate de la barra con las palmas hacia delante y sube hasta que la barbilla pase la barra.', '4 series hasta el fallo'),
('Remo con barra', 'Espalda', 'Intermedio', 'Da grosor a la parte media de la espalda.', 'Inclina el tronco, mantén la espalda recta y tira de la barra hacia el abdomen.', '4 series de 10'),
('Jalón al pecho', 'Espalda', 'Principiante', 'Alternativa a las dominadas en máquina.', 'Sentado, tira de la barra hacia la parte alta del pecho juntando los omóplatos.', '3 series de 12'),
('Peso muerto', 'Espalda', 'Avanzado', 'Ejercicio global para toda la parte de atrás del cuerpo.', 'Con la espalda recta, levanta la barra desde el suelo estirando cadera y rodillas a la vez.', '4 series de 6'),
('Sentadillas', 'Piernas', 'Intermedio', 'El ejercicio más completo para las piernas.', 'Baja como si te fueras a sentar, con la espalda recta, hasta que los muslos queden paralelos al suelo.', '4 series de 10'),
('Zancadas', 'Piernas', 'Principiante', 'Trabaja cuádriceps y glúteo pierna a pierna.', 'Da un paso adelante y baja la rodilla de atrás casi hasta el suelo, luego cambia de pierna.', '3 series de 12 por pierna'),
('Prensa de piernas', 'Piernas', 'Principiante', 'Ejercicio en máquina, muy seguro para empezar.', 'Empuja la plataforma con los pies sin llegar a bloquear las rodillas.', '4 series de 12'),
('Peso muerto rumano', 'Piernas', 'Avanzado', 'Se centra en isquiotibiales y glúteo.', 'Baja la barra pegada a las piernas con las rodillas casi rectas y sube apretando el glúteo.', '4 series de 8'),
('Crunch abdominal', 'Abdominales', 'Principiante', 'El ejercicio básico de abdomen.', 'Tumbado boca arriba, sube el tronco contrayendo el abdomen sin tirar del cuello.', '4 series de 20'),
('Plancha', 'Abdominales', 'Principiante', 'Ejercicio en isométrico para toda la zona media.', 'Apóyate en los antebrazos y las puntas de los pies y aguanta con el cuerpo recto.', '3 series de 45 segundos'),
('Elevación de piernas', 'Abdominales', 'Intermedio', 'Trabaja la parte baja del abdomen.', 'Colgado o tumbado, sube las piernas rectas y bájalas despacio.', '4 series de 15'),
('Rueda abdominal', 'Abdominales', 'Avanzado', 'Ejercicio exigente para toda la zona media.', 'De rodillas, rueda hacia delante estirando el cuerpo y vuelve sin arquear la zona lumbar.', '3 series de 10'),
('Curl de bíceps', 'Brazos', 'Principiante', 'Ejercicio clásico para el bíceps.', 'De pie, dobla los codos subiendo las mancuernas sin balancear el cuerpo.', '4 series de 12'),
('Fondos en paralelas', 'Brazos', 'Avanzado', 'Ejercicio duro para tríceps y pecho.', 'Apoyado en las paralelas, baja doblando los codos y empuja hacia arriba.', '4 series de 10'),
('Press militar', 'Hombros', 'Intermedio', 'Trabaja el hombro de forma completa.', 'De pie o sentado, empuja la barra desde los hombros hasta encima de la cabeza.', '4 series de 8'),
('Elevaciones laterales', 'Hombros', 'Principiante', 'Se centra en la parte lateral del hombro.', 'Con una mancuerna en cada mano, sube los brazos por los lados hasta la altura de los hombros.', '4 series de 15');
