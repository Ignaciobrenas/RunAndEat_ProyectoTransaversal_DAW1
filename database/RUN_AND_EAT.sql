/* 
Base de datos de la aplicación de gestión de eventos gastronómicos RUN AND EAT
Creada por Ignacio Breñas y Gorka Ramírez en diciembre de 2025 
y optimizada el 12 de marzo de 2026.
Esta base de datos almacena toda la información necesaria para el 
funcionamiento de  RUN AND EAT, una aplicación web dedicada 
a la organización y gestión de eventos gastronómicos.

Contiene información sobre:

- Usuarios registrados en la plataforma, incluyendo clientes y organizadores.
- Categorías de eventos gastronómicos para clasificar las experiencias.
- Eventos gastronómicos creados por los organizadores, con detalles como
  fecha, ubicación, precio, capacidad y descripción.
- Inscripciones de usuarios a los diferentes eventos.
- Valoraciones y comentarios realizados por los usuarios después de asistir
  a un evento.
- Mensajes enviados desde el formulario de contacto de la web.
- Eventos favoritos guardados por los usuarios.
La estructura relacional permite gestionar de forma eficiente la relación 
entre usuarios, eventos, inscripciones y valoraciones, facilitando la
administración de la plataforma.
Proyecto académico desarrollado para el ciclo formativo de 
Desarrollo de Aplicaciones Web (DAW).
*/
CREATE DATABASE IF NOT EXISTS RUN_AND_EAT;

USE RUN_AND_EAT;
 
CREATE TABLE USUARIOS (
    id_usuario      INT          AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    email           VARCHAR(100) NOT NULL UNIQUE,
    contrasena      VARCHAR(255) NOT NULL,
    tipo_usuario    ENUM('cliente', 'organizador') DEFAULT 'cliente',
    foto_perfil     VARCHAR(255) DEFAULT 'img/user.png',
    fecha_registro  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    activo          BOOLEAN      DEFAULT TRUE
);
 
CREATE TABLE CATEGORIAS (
    id_categoria INT         AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(50) NOT NULL UNIQUE,
    descripcion  TEXT,
    icono        VARCHAR(100)
);
 
CREATE TABLE EVENTOS (
    id_evento           INT            AUTO_INCREMENT PRIMARY KEY,
    id_organizador      INT            NOT NULL,
    id_categoria        INT            NOT NULL,
    titulo              VARCHAR(150)   NOT NULL,
    descripcion         TEXT           NOT NULL,
    imagen              VARCHAR(255)   DEFAULT 'img/user.png',
    fecha               DATE           NOT NULL,
    hora                TIME           NOT NULL,
    ciudad              VARCHAR(100)   NOT NULL,
    pais                VARCHAR(100)   DEFAULT 'España',
    direccion_completa  VARCHAR(255)   NOT NULL,
    precio              DECIMAL(10, 2) NOT NULL,
    capacidad           INT            NOT NULL,
    plazas_disponibles  INT            NOT NULL,
    que_incluye         TEXT,
    que_traer           TEXT,
    notas_adicionales   TEXT,
    valoracion_promedio DECIMAL(3, 2)  DEFAULT 0.00,
    total_valoraciones  INT            DEFAULT 0,
    fecha_creacion      TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    activo              BOOLEAN        DEFAULT TRUE,

    FOREIGN KEY (id_organizador) REFERENCES USUARIOS(id_usuario)     ON DELETE CASCADE,
    FOREIGN KEY (id_categoria)   REFERENCES CATEGORIAS(id_categoria) ON DELETE RESTRICT
);
 
CREATE TABLE INSCRIPCIONES (
    id_inscripcion    INT       AUTO_INCREMENT PRIMARY KEY,
    id_evento         INT       NOT NULL,
    id_usuario        INT       NOT NULL,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado            ENUM('confirmada', 'cancelada', 'en_espera') DEFAULT 'confirmada',

    FOREIGN KEY (id_evento)  REFERENCES EVENTOS(id_evento)   ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario) ON DELETE CASCADE,
    UNIQUE KEY (id_evento, id_usuario)
);
 
CREATE TABLE VALORACIONES (
    id_valoracion    INT       AUTO_INCREMENT PRIMARY KEY,
    id_evento        INT       NOT NULL,
    id_usuario       INT       NOT NULL,
    puntuacion       INT       NOT NULL CHECK (puntuacion BETWEEN 1 AND 5),
    comentario       TEXT,
    fecha_valoracion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_evento)  REFERENCES EVENTOS(id_evento)   ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario) ON DELETE CASCADE,
    UNIQUE KEY (id_evento, id_usuario)
);
 
CREATE TABLE MENSAJES_CONTACTO (
    id_mensaje  INT          AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL,
    asunto      ENUM('consulta-general', 'soporte-tecnico', 'evento', 'organizador', 'sugerencia', 'otro') NOT NULL,
    mensaje     TEXT         NOT NULL,
    fecha_envio TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    leido       BOOLEAN      DEFAULT FALSE
);
 
CREATE TABLE FAVORITOS (
    id_favorito    INT       AUTO_INCREMENT PRIMARY KEY,
    id_usuario     INT       NOT NULL,
    id_evento      INT       NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_evento)  REFERENCES EVENTOS(id_evento)   ON DELETE CASCADE,
    UNIQUE KEY (id_usuario, id_evento)
);
 
CREATE INDEX idx_eventos_fecha         ON EVENTOS(fecha);
CREATE INDEX idx_eventos_ciudad        ON EVENTOS(ciudad);
CREATE INDEX idx_eventos_precio        ON EVENTOS(precio);
CREATE INDEX idx_eventos_categoria     ON EVENTOS(id_categoria);
CREATE INDEX idx_eventos_organizador   ON EVENTOS(id_organizador);
CREATE INDEX idx_usuarios_email        ON USUARIOS(email);
CREATE INDEX idx_inscripciones_usuario ON INSCRIPCIONES(id_usuario);
CREATE INDEX idx_valoraciones_evento   ON VALORACIONES(id_evento);
 
INSERT INTO CATEGORIAS (nombre, descripcion) VALUES
    ('Cata de Vino',          'Eventos de degustación de vinos'),
    ('Hamburguesas',          'Eventos centrados en hamburguesas artesanales'),
    ('Restaurante',           'Experiencias en restaurantes variados'),
    ('Bar / Tapas',           'Ruta de tapas y bares'),
    ('Comida China',          'Gastronomía china tradicional'),
    ('Comida Mexicana',       'Tacos, enchiladas y más'),
    ('Comida Filipina',       'Cocina filipina auténtica'),
    ('Comida Italiana',       'Pasta, pizza y cocina italiana'),
    ('Comida Japonesa',       'Sushi, ramen y más'),
    ('Comida India',          'Curry y especias de la India'),
    ('Cafetería',             'Eventos en cafeterías'),
    ('Pizzería',              'Degustación de pizzas'),
    ('Sushi',                 'Experiencias de sushi'),
    ('Tacos',                 'Ruta de tacos'),
    ('Opciones Veganas',      'Eventos con opciones veganas'),
    ('Opciones Vegetarianas', 'Eventos vegetarianos');
 
CREATE USER IF NOT EXISTS 'ignacio'@'localhost' IDENTIFIED BY 'Ignacio2026!';
GRANT ALL PRIVILEGES ON RUN_AND_EAT.* TO 'ignacio'@'localhost' WITH GRANT OPTION;
 
CREATE USER IF NOT EXISTS 'gorka'@'localhost' IDENTIFIED BY 'Gorka2026!';
GRANT ALL PRIVILEGES ON RUN_AND_EAT.* TO 'gorka'@'localhost' WITH GRANT OPTION;
 
FLUSH PRIVILEGES;
 
DELIMITER $$
 
CREATE PROCEDURE CrearEvento(
    IN p_id_organizador INT,
    IN p_id_categoria   INT,
    IN p_titulo         VARCHAR(150),
    IN p_descripcion    TEXT,
    IN p_imagen         VARCHAR(255),
    IN p_fecha          DATE,
    IN p_hora           TIME,
    IN p_ciudad         VARCHAR(100),
    IN p_direccion      VARCHAR(255),
    IN p_precio         DECIMAL(10,2),
    IN p_capacidad      INT,
    IN p_que_incluye    TEXT,
    IN p_que_traer      TEXT
)
BEGIN
    INSERT INTO EVENTOS (
        id_organizador, id_categoria, titulo, descripcion, imagen,
        fecha, hora, ciudad, direccion_completa,
        precio, capacidad, plazas_disponibles,
        que_incluye, que_traer
    ) VALUES (
        p_id_organizador, p_id_categoria, p_titulo, p_descripcion, p_imagen,
        p_fecha, p_hora, p_ciudad, p_direccion,
        p_precio, p_capacidad, p_capacidad,
        p_que_incluye, p_que_traer
    );
END$$
 
 
CREATE PROCEDURE EliminarEvento(
    IN p_id_evento INT
)
BEGIN
    DELETE FROM EVENTOS WHERE id_evento = p_id_evento;
END$$
 
 
CREATE PROCEDURE ModificarEvento(
    IN p_id_evento    INT,
    IN p_id_categoria INT,
    IN p_titulo       VARCHAR(150),
    IN p_descripcion  TEXT,
    IN p_fecha        DATE,
    IN p_hora         TIME,
    IN p_ciudad       VARCHAR(100),
    IN p_direccion    VARCHAR(255),
    IN p_precio       DECIMAL(10,2),
    IN p_capacidad    INT,
    IN p_que_incluye  TEXT,
    IN p_que_traer    TEXT
)
BEGIN
    UPDATE EVENTOS
    SET
        id_categoria       = p_id_categoria,
        titulo             = p_titulo,
        descripcion        = p_descripcion,
        fecha              = p_fecha,
        hora               = p_hora,
        ciudad             = p_ciudad,
        direccion_completa = p_direccion,
        precio             = p_precio,
        capacidad          = p_capacidad,
        que_incluye        = p_que_incluye,
        que_traer          = p_que_traer
    WHERE id_evento = p_id_evento;
END$$
 
 
CREATE PROCEDURE AnadirUsuario(
    IN p_nombre       VARCHAR(100),
    IN p_email        VARCHAR(100),
    IN p_contrasena   VARCHAR(255),
    IN p_tipo_usuario VARCHAR(20)
)
BEGIN
    INSERT INTO USUARIOS (nombre_completo, email, contrasena, tipo_usuario)
    VALUES (p_nombre, p_email, p_contrasena, p_tipo_usuario);
END$$
 
 
CREATE PROCEDURE BorrarUsuario(
    IN p_id_usuario INT
)
BEGIN
    DELETE FROM USUARIOS WHERE id_usuario = p_id_usuario;
END$$
 
 
CREATE PROCEDURE ModificarUsuario(
    IN p_id_usuario INT,
    IN p_nombre     VARCHAR(100),
    IN p_email      VARCHAR(100),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    UPDATE USUARIOS
    SET nombre_completo = p_nombre,
        email           = p_email,
        contrasena      = p_contrasena
    WHERE id_usuario = p_id_usuario;
END$$
 
DELIMITER ;