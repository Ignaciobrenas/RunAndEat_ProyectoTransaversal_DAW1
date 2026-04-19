<div align="center">

<img src="public/img/logo.png" alt="Run & Eat Logo" width="120" />

# Run &amp; Eat

**Plataforma de eventos gastronómicos urbanos**

[![PHP](https://img.shields.io/badge/PHP-8.0+-FFA208?style=flat-square&labelColor=0A192F&color=FFA208)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-FFA208?style=flat-square&labelColor=0A192F&color=FFA208)](https://www.mysql.com/)
[![HTML](https://img.shields.io/badge/HTML5-CSS3-FFA208?style=flat-square&labelColor=0A192F&color=FFA208)](#)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6-FFA208?style=flat-square&labelColor=0A192F&color=FFA208)](#)
[![License](https://img.shields.io/badge/Proyecto-Académico-64FFDA?style=flat-square&labelColor=0A192F&color=64FFDA)](#)
[![Version](https://img.shields.io/badge/versión-1.0.0-64FFDA?style=flat-square&labelColor=0A192F&color=64FFDA)](#)

*DAW · Stucom Barcelona · 2026*

---

</div>

## Índice

- [Descripción](#-descripción)
- [Stack tecnológico](#-stack-tecnológico)
- [Estructura del proyecto](#-estructura-del-proyecto)
- [Funcionalidades](#-funcionalidades)
- [Roles de usuario](#-roles-de-usuario)
- [Base de datos](#-base-de-datos)
- [Instalación local](#-instalación-local)
- [Seguridad](#-seguridad)
- [Equipo](#-equipo)

---

## Descripción

**Run & Eat** es una plataforma web especializada en la publicación y gestión de eventos gastronómicos urbanos. Conecta a organizadores de experiencias culinarias con participantes que buscan descubrir la gastronomía local de una forma activa y social: carreras populares, catas de vino, burger runs, rutas de tapas y mucho más.

El proyecto fue desarrollado íntegramente como trabajo académico del ciclo de **Desarrollo de Aplicaciones Web (DAW)** en Stucom, Barcelona, usando tecnologías web estándar sin frameworks externos.

| Característica | Detalle |
|---|---|
| Tipo | Plataforma web de eventos |
| Ciudad principal | Barcelona, España |
| Roles | Cliente · Organizador |
| Autenticación | Sesiones PHP nativas |
| Sin dependencias externas | PHP nativo + MySQL |

---

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.0+ (nativo, sin frameworks) |
| Base de datos | MySQL 8.0 — MySQLi con prepared statements |
| Frontend | HTML5 + CSS3 + JavaScript ES6 |
| Servidor | Apache (XAMPP recomendado para local) |
| Control de versiones | Git |
| Subida de archivos | PHP `finfo` + `move_uploaded_file()` |

---

## Estructura del proyecto

```
run-and-eat/
│
├── controller/                  # Lógica de negocio y enrutamiento PHP
│   ├── UserController.php       # Login, registro, logout
│   ├── auth_guard.php           # Middleware de autenticación y roles
│   ├── index.php                # Listado de eventos (página principal)
│   ├── perfil.php               # Gestión del perfil de usuario
│   ├── crear-evento.php         # Creación de eventos (solo organizadores)
│   ├── login.php                # Vista del formulario de login
│   ├── registro.php             # Vista del formulario de registro
│   └── logout.php               # Destrucción de sesión
│
├── view/                        # Vistas estáticas HTML
│   ├── evento.html              # Detalle de evento con mapa
│   ├── contacto.html
│   ├── faq.html
│   ├── about-us.html
│   ├── Ignacio.html
│   └── Gorka.html
│
└── public/                      # Assets estáticos públicos
    ├── style/
    │   └── styles.css           # Hoja de estilos global
    ├── scripts/
    │   └── script.js            # JavaScript global
    ├── img/
    │   ├── logo.png
    │   └── user-photos/         # Fotos de perfil subidas por usuarios
    └── svg/                     # Iconos vectoriales
```

---

## Funcionalidades

### Autenticación

| Acción | Descripción | Archivo |
|---|---|---|
| Registro | Validación de campos, formato de email, coincidencia de contraseñas, tipo de usuario y duplicados en BD | `UserController.php` |
| Login | Comprobación de credenciales contra BD y escritura de sesión | `UserController.php` |
| Logout | Destrucción completa de sesión con `session_unset()` + `session_destroy()` | `UserController.php` |
| Guard | Middleware que protege rutas por rol; redirige a forbidden si no autorizado | `auth_guard.php` |

### Perfil de usuario

| Acción | Descripción |
|---|---|
| Editar información | Actualización de nombre y email con validación de email duplicado en otra cuenta |
| Cambiar contraseña | Verificación de contraseña actual antes de aplicar cambios; mínimo 8 caracteres |
| Foto de perfil | Subida con validación de MIME real (`finfo`), extensión permitida y límite de 2 MB |
| Mis eventos | Listado de eventos inscritos mediante `JOIN` con la tabla `INSCRIPCIONES` |

### Eventos

| Acción | Rol | Descripción |
|---|---|---|
| Listar eventos | Todos | Página principal con paginación y buscador por ciudad |
| Ver detalle | Todos | Información completa, mapa de Google Maps integrado, botón de inscripción |
| Crear evento | Organizador | Formulario con imagen, nivel, tipo de cocina, precio, aforo y distancia |
| Inscripción | Cliente | Requiere sesión activa; redirige al login si no está autenticado |

---

## Roles de usuario

El acceso a las diferentes secciones se gestiona a través de `auth_guard.php` mediante tres funciones principales:

```php
auth_require_login();           // Requiere sesión activa
auth_require_role("organizador"); // Requiere rol específico
auth_is("organizador");         // Devuelve bool — uso condicional en vistas
auth_check();                   // Comprueba si hay sesión activa
```

| Permiso | `cliente` | `organizador` |
|---|---|---|
| Ver listado de eventos | ✅ | ✅ |
| Ver detalle de evento | ✅ | ✅ |
| Inscribirse en evento | ✅ | ✅ |
| Gestionar perfil | ✅ | ✅ |
| Crear eventos | ❌ | ✅ |
| Botón "Crear evento" en nav | ❌ | ✅ |

Si un usuario con rol `cliente` intenta acceder a una ruta protegida por `organizador`, `auth_guard.php` renderiza una página de **acceso restringido** en lugar de redirigir, mostrando el nombre del usuario y un enlace al formulario de contacto.

---

## Base de datos

**Nombre:** `run_and_eat`  
**Motor:** MySQL 8.0  
**Charset:** UTF-8

### Tablas

| Tabla | Descripción | Campos clave |
|---|---|---|
| `USUARIOS` | Registro de todos los usuarios | `id_usuario`, `nombre_completo`, `email`, `contrasena`, `tipo_usuario`, `foto_perfil`, `fecha_registro`, `activo` |
| `EVENTOS` | Eventos publicados por organizadores | `id_evento`, `id_organizador`, `titulo`, `descripcion`, `fecha`, `hora`, `ciudad`, `direccion`, `precio`, `participantes`, `nivel`, `tipo` |
| `INSCRIPCIONES` | Relación N:M entre usuarios y eventos | `id_usuario`, `id_evento` |
| `VALORACIONES` | Reseñas de usuarios sobre eventos asistidos | `id_valoracion`, `id_usuario`, `id_evento`, `puntuacion`, `comentario` |
| `FAVORITOS` | Eventos guardados por usuarios | `id_usuario`, `id_evento` |

### Conexión

```php
$conexion = mysqli_connect("localhost", "root", "", "run_and_eat");
mysqli_set_charset($conexion, "utf8");
```

> La configuración por defecto usa usuario `root` sin contraseña, adecuada para entorno local con XAMPP. En producción debe cambiarse.

---

## Instalación local

### Requisitos previos

- PHP 8.0 o superior
- MySQL 8.0
- Apache — se recomienda **XAMPP**
- Git

### Pasos

```bash
# 1. Clona el repositorio
git clone https://github.com/usuario/RunAndEat_ProyectoTransaversal_DAW1
cd run-and-eat
```

```bash
# 2. Copia la carpeta al directorio de Apache
# XAMPP en Windows:  C:\xampp\htdocs\run-and-eat
# XAMPP en Linux:    /opt/lampp/htdocs/run-and-eat
# Apache en Linux:   /var/www/html/run-and-eat
```

```bash
# 3. Importa la base de datos desde phpMyAdmin
#    → Crea una BD llamada "run_and_eat"
#    → Importa el archivo .sql incluido en el proyecto
```

```bash
# 4. Arranca Apache y MySQL desde el panel de XAMPP
#    o con systemctl en Linux:
sudo systemctl start apache2
sudo systemctl start mysql
```

```bash
# 5. Accede desde el navegador
http://localhost/RunAndEat_ProyectoTransaversal_DAW1/controller/index.php
```

### Permisos de escritura

La carpeta de fotos de perfil debe tener permisos de escritura para el servidor web:

```bash
chmod 755 public/img/user-photos/
# o en Windows: asegúrate de que Apache tiene acceso de escritura a esa carpeta
```

---

## Seguridad

| Medida | Estado | Detalle |
|---|---|---|
| Prepared statements | ✅ Implementado | Todas las consultas usan `mysqli_prepare()` — protección contra SQL Injection |
| Escape de salida HTML | ✅ Implementado | `htmlspecialchars()` en todos los outputs de datos de usuario |
| Control de sesión | ✅ Implementado | Middleware `auth_guard.php` con control por rol en cada ruta protegida |
| Validación de subidas | ✅ Implementado | Verificación de MIME real con `finfo`, extensión y límite de 2 MB |
| Hash de contraseñas | ❌ Pendiente | Las contraseñas se almacenan en **texto plano** — debe migrarse a `password_hash()` |
| Protección CSRF | ⚠️ Parcial | No hay tokens CSRF en los formularios — recomendable añadirlos en producción |
| HTTPS | ⚠️ Entorno local | No configurado — obligatorio antes de cualquier despliegue en producción |

> **Aviso importante:** Las contraseñas se guardan actualmente en texto plano. Antes de cualquier despliegue en producción es imprescindible migrar a `password_hash()` / `password_verify()` de PHP.

---

## Equipo

<div align="center">

| | Nombre | Rol | Responsabilidades |
|---|---|---|---|
| 👤 | **Ignacio Breñas** | Co-CEO · Co-Fundador | Arquitectura de BD MySQL, lógica de negocio backend en PHP, procedimientos almacenados |
| 👤 | **Gorka Ramírez** | Co-CEO · Co-Fundador | Desarrollo de todas las vistas, experiencia de usuario, maquetación y diseño de interfaz |

</div>

**Stack individual:**

- **Ignacio** — HTML · CSS · MySQL · PHP · Backend · Git
- **Gorka** — HTML · CSS · JavaScript · Frontend · Git · Imagen de marca·

---

<div align="center">

<img src="public/img/logo.png" alt="Run & Eat" width="48" />

**Run & Eat** · Stucom Pelai · DAW 1 · 2026

*Proyecto académico — todos los derechos reservados*

</div>