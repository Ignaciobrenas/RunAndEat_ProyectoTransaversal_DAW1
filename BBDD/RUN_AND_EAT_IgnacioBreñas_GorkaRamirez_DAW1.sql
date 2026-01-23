CREATE DATABASE BBDD_RUN_AND_EAT;
USE BBDD_RUN_AND_EAT;

CREATE TABLE USUARIOS (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(15),
    email VARCHAR(50) UNIQUE,
    contrasena VARCHAR(15)
);

CREATE TABLE CATEGORIAS (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20),
    descripcion TEXT
);

CREATE TABLE EVENTOS (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_organizador INT,
    id_categoria INT,
    titulo VARCHAR(30),
    rol VARCHAR(15),
    localizacion VARCHAR(50),
    fecha DATE,
    capacidad INT,
    precio INT,
    puntuacion INT,
    telefono VARCHAR(20),

    FOREIGN KEY (id_organizador) REFERENCES USUARIOS(id_usuario),
    FOREIGN KEY (id_categoria) REFERENCES CATEGORIAS(id_categoria)
);

CREATE TABLE INSCRIPCION (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    id_usuario INT,
    plazas INT,

    FOREIGN KEY (id_evento) REFERENCES EVENTOS(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario)
);


CREATE TABLE COMENTARIOS (
    id_comentarios INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    id_usuario INT,
    comentario TEXT,

    FOREIGN KEY (id_evento) REFERENCES EVENTOS(id_evento),
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario)
);

CREATE TABLE AUDITORIAS (
    id_auditoria INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    objetivo VARCHAR(50),
    metadatos JSON,

    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id_usuario)
);
