<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "run_and_eat");
mysqli_set_charset($conexion, "utf8");

$id_usuario    = $_SESSION["id_usuario"];
$mensaje_ok    = "";
$mensaje_error = "";

// ── CAMBIAR FOTO DE PERFIL ────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_photo"])) {
    if (!isset($_FILES["foto_perfil"]) || $_FILES["foto_perfil"]["error"] !== UPLOAD_ERR_OK) {
        $mensaje_error = "No se ha podido subir la imagen. Inténtalo de nuevo.";
    } else {
        $archivo   = $_FILES["foto_perfil"];
        $tamano    = $archivo["size"];
        $tmp       = $archivo["tmp_name"];
        $extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

        $extensiones_permitidas = ["jpg", "jpeg", "png", "webp", "gif"];
        $mimes_permitidos       = ["image/jpeg", "image/png", "image/webp", "image/gif"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $tmp);
        finfo_close($finfo);

        if (!in_array($extension, $extensiones_permitidas) || !in_array($mime, $mimes_permitidos)) {
            $mensaje_error = "Formato no permitido. Usa JPG, PNG, WEBP o GIF.";
        } elseif ($tamano > 2 * 1024 * 1024) {
            $mensaje_error = "La imagen no puede superar los 2 MB.";
        } else {
            $directorio = __DIR__ . "/../public/img/user-photos/";
            if (!is_dir($directorio)) {
                mkdir($directorio, 0755, true);
            }

            $nombre_archivo = "user_" . $id_usuario . "_" . time() . "." . $extension;
            $ruta_destino   = $directorio . $nombre_archivo;

            if (move_uploaded_file($tmp, $ruta_destino)) {
                $ruta_bd   = "public/img/user-photos/" . $nombre_archivo;
                $stmt_foto = mysqli_prepare($conexion,
                    "UPDATE USUARIOS SET foto_perfil = ? WHERE id_usuario = ?");
                mysqli_stmt_bind_param($stmt_foto, "si", $ruta_bd, $id_usuario);
                if (mysqli_stmt_execute($stmt_foto)) {
                    $_SESSION["foto_perfil"] = $ruta_bd;
                    $mensaje_ok = "Foto de perfil actualizada correctamente.";
                } else {
                    $mensaje_error = "Error al guardar la foto en la base de datos.";
                }
                mysqli_stmt_close($stmt_foto);
            } else {
                $mensaje_error = "Error al mover el archivo. Comprueba los permisos del directorio.";
            }
        }
    }
}

// ── ACTUALIZAR INFORMACIÓN PERSONAL ──────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_info"])) {
    $nombre = trim($_POST["nombre"] ?? "");
    $email  = trim($_POST["email"]  ?? "");

    if (empty($nombre) || empty($email)) {
        $mensaje_error = "Por favor, rellena todos los campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje_error = "El formato del correo electrónico no es válido.";
    } else {
        $stmt_check = mysqli_prepare($conexion,
            "SELECT id_usuario FROM USUARIOS WHERE email = ? AND id_usuario != ? LIMIT 1");
        mysqli_stmt_bind_param($stmt_check, "si", $email, $id_usuario);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $mensaje_error = "Ese correo ya está en uso por otra cuenta.";
        } else {
            $stmt_up = mysqli_prepare($conexion,
                "UPDATE USUARIOS SET nombre_completo = ?, email = ? WHERE id_usuario = ?");
            mysqli_stmt_bind_param($stmt_up, "ssi", $nombre, $email, $id_usuario);
            if (mysqli_stmt_execute($stmt_up)) {
                $_SESSION["nombre_completo"] = $nombre;
                $mensaje_ok = "Información actualizada correctamente.";
            } else {
                $mensaje_error = "Error al actualizar. Inténtalo de nuevo.";
            }
            mysqli_stmt_close($stmt_up);
        }
        mysqli_stmt_close($stmt_check);
    }
}

// ── CAMBIAR CONTRASEÑA ────────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_password"])) {
    $current  = $_POST["current-password"]    ?? "";
    $nueva    = $_POST["new-password"]         ?? "";
    $confirma = $_POST["confirm-new-password"] ?? "";

    if (empty($current) || empty($nueva) || empty($confirma)) {
        $mensaje_error = "Rellena todos los campos de contraseña.";
    } elseif (strlen($nueva) < 8) {
        $mensaje_error = "La nueva contraseña debe tener al menos 8 caracteres.";
    } elseif ($nueva !== $confirma) {
        $mensaje_error = "Las contraseñas nuevas no coinciden.";
    } else {
        $stmt_h = mysqli_prepare($conexion,
            "SELECT contrasena FROM USUARIOS WHERE id_usuario = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt_h, "i", $id_usuario);
        mysqli_stmt_execute($stmt_h);
        $res_h = mysqli_stmt_get_result($stmt_h);
        $row_h = mysqli_fetch_assoc($res_h);
        mysqli_stmt_close($stmt_h);

        if ($current !== ($row_h["contrasena"] ?? "")) {
            $mensaje_error = "La contraseña actual no es correcta.";
        } else {
            $stmt_pw = mysqli_prepare($conexion,
                "UPDATE USUARIOS SET contrasena = ? WHERE id_usuario = ?");
            mysqli_stmt_bind_param($stmt_pw, "si", $nueva, $id_usuario);
            if (mysqli_stmt_execute($stmt_pw)) {
                $mensaje_ok = "Contraseña actualizada correctamente.";
            } else {
                $mensaje_error = "Error al cambiar la contraseña.";
            }
            mysqli_stmt_close($stmt_pw);
        }
    }
}

// ── LEER DATOS ACTUALES DEL USUARIO ──────────────────────────────────────────
$stmt_u = mysqli_prepare($conexion,
    "SELECT nombre_completo, email, tipo_usuario, fecha_registro, foto_perfil
     FROM USUARIOS WHERE id_usuario = ? LIMIT 1");
mysqli_stmt_bind_param($stmt_u, "i", $id_usuario);
mysqli_stmt_execute($stmt_u);
$res_u   = mysqli_stmt_get_result($stmt_u);
$usuario = mysqli_fetch_assoc($res_u);
mysqli_stmt_close($stmt_u);

if (!$usuario) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// ── LEER EVENTOS INSCRITOS ────────────────────────────────────────────────────
$eventos_usuario = [];
$stmt_ev = mysqli_prepare($conexion,
    "SELECT e.id_evento, e.titulo, e.fecha, e.ciudad AS ubicacion
     FROM EVENTOS e
     INNER JOIN INSCRIPCIONES i ON i.id_evento = e.id_evento
     WHERE i.id_usuario = ?
     ORDER BY e.fecha DESC");
if ($stmt_ev) {
    mysqli_stmt_bind_param($stmt_ev, "i", $id_usuario);
    mysqli_stmt_execute($stmt_ev);
    $res_ev = mysqli_stmt_get_result($stmt_ev);
    while ($row = mysqli_fetch_assoc($res_ev)) {
        $eventos_usuario[] = $row;
    }
    mysqli_stmt_close($stmt_ev);
}

mysqli_close($conexion);

$foto_src = !empty($usuario["foto_perfil"])
    ? "../" . htmlspecialchars($usuario["foto_perfil"])
    : "../public/img/user.png";

$fecha_registro = "";
if (!empty($usuario["fecha_registro"])) {
    $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
              "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    $ts = strtotime($usuario["fecha_registro"]);
    $fecha_registro = $meses[(int)date("n", $ts) - 1] . " " . date("Y", $ts);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Run & Eat</title>
    <link rel="icon" type="image/png" href="../public/img/logo.png">
    <link rel="stylesheet" href="../public/style/styles.css">
    <style>
   .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 14px; font-size: 0.9rem; }
        .alert-error   { background: #fdecea; color: #c0392b; border: 1px solid #f5c6cb; }
        .alert-success { background: #eafaf1; color: #1e8449; border: 1px solid #a9dfbf; }

        #foto_perfil_input {
            display: none;
        }

        label.change-photo-btn {
            cursor: pointer;
        }

        .btn-subir-foto {
            display: block;
            margin-top: 8px;
            background-color: transparent;
            border: 1px solid #FFA208;
            color: #FFA208;
            padding: 0.3rem 0.9rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.78rem;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.3s;
            width: 120px;
            text-align: center;
        }

        .btn-subir-foto:hover {
            background-color: #FFA208;
            color: #0a192f;
        }

        .foto-form-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo-section">
                <img src="../public/img/logo.png" alt="Run & Eat"
                     onclick="location.href='../index.html'">
                <div class="nav-left">
                    <button onclick="location.href='../index.html'">Eventos</button>
                    <button onclick="location.href='../view/contacto.html'">Contacto</button>
                </div>
            </div>
            <div class="nav-right">
                <button class="btn-registro" onclick="location.href='perfil.php'">MI PERFIL</button>
                <form method="POST" action="UserController.php" style="display:inline;">
                    <button type="submit" name="logout" class="btn-login">CERRAR SESIÓN</button>
                </form>
            </div>
        </div>
    </header>

    <main>
        <div class="perfil-container">

            <?php if ($mensaje_ok): ?>
                <div class="alert alert-success"><?= htmlspecialchars($mensaje_ok) ?></div>
            <?php endif; ?>
            <?php if ($mensaje_error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($mensaje_error) ?></div>
            <?php endif; ?>

            <div class="perfil-header">
                <div class="perfil-top">

                    <form method="POST" action="perfil.php" enctype="multipart/form-data">
                        <input type="hidden" name="update_photo" value="1">

                        <div class="foto-form-wrap">
                            <div class="perfil-image-container">
                                <img src="<?= $foto_src ?>" alt="Foto de perfil" class="perfil-image">


                                <label for="foto_perfil_input" class="change-photo-btn">Cambiar</label>
                                <input type="file" id="foto_perfil_input" name="foto_perfil"
                                       accept="image/jpeg,image/png,image/webp,image/gif">
                            </div>
                            <button type="submit" class="btn-subir-foto">Subir foto</button>
                        </div>

                    </form>

                    <div class="perfil-info">
                        <h2><?= htmlspecialchars($usuario["nombre_completo"]) ?></h2>
                        <p><?= htmlspecialchars($usuario["email"]) ?></p>
                        <p>Miembro desde: <?= htmlspecialchars($fecha_registro) ?></p>
                    </div>
                </div>
            </div>

            <div class="perfil-sections">

                <div class="perfil-section">
                    <h3>Información Personal</h3>
                    <form method="POST" action="perfil.php">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" id="nombre" name="nombre"
                                   value="<?= htmlspecialchars($usuario["nombre_completo"]) ?>"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                   value="<?= htmlspecialchars($usuario["email"]) ?>"
                                   required>
                        </div>
                        <button type="submit" name="update_info" class="btn-submit">
                            Guardar Cambios
                        </button>
                    </form>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="perfil-section">
                    <h3>Cambiar Contraseña</h3>
                    <form method="POST" action="perfil.php">
                        <div class="form-group">
                            <label for="current-password">Contraseña Actual</label>
                            <input type="password" id="current-password"
                                   name="current-password" placeholder="••••••••" required>
                        </div>
                        <div class="form-group">
                            <label for="new-password">Nueva Contraseña</label>
                            <input type="password" id="new-password"
                                   name="new-password" placeholder="••••••••" minlength="8" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm-new-password">Confirmar Nueva Contraseña</label>
                            <input type="password" id="confirm-new-password"
                                   name="confirm-new-password" placeholder="••••••••" minlength="8" required>
                        </div>
                        <button type="submit" name="update_password" class="btn-submit">
                            Actualizar Contraseña
                        </button>
                    </form>
                </div>

            </div>

            <!-- Mis Eventos -->
            <div class="perfil-section" style="margin-top: 30px;">
                <h3>Mis Eventos</h3>
                <div class="my-eventos-list">
                    <?php if (!empty($eventos_usuario)): ?>
                        <?php foreach ($eventos_usuario as $ev): ?>
                            <div class="evento-item"
                                 onclick="location.href='../view/evento.html?id=<?= $ev['id_evento'] ?>'"
                                 style="cursor: pointer;">
                                <div class="evento-item-info">
                                    <h4><?= htmlspecialchars($ev["titulo"]) ?></h4>
                                    <p><?= htmlspecialchars($ev["ubicacion"]) ?></p>
                                </div>
                                <div class="evento-item-fecha">
                                    <?= htmlspecialchars(date("d M Y", strtotime($ev["fecha"]))) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #aaa;">Todavía no estás inscrito en ningún evento.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>

    <footer class="site-footer">
        <div class="site-footer__inner">
            <div class="site-footer__brand">
                <img src="../public/img/logo.png" alt="Run & Eat" class="site-footer__logo">
                <p class="site-footer__tagline">La plataforma de eventos gastronómicos.</p>
                <p class="site-footer__copy">&copy; 2026 Run &amp; Eat. Todos los derechos reservados.</p>
            </div>
            <div class="site-footer__nav">
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Plataforma</h4>
                    <ul>
                        <li><a href="../index.html">Eventos</a></li>
                        <li><a href="../view/crear-evento.html">Crear evento</a></li>
                        <li><a href="registro.php">Registro</a></li>
                        <li><a href="login.php">Iniciar sesión</a></li>
                    </ul>
                </div>
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Soporte</h4>
                    <ul>
                        <li><a href="../view/faq.html">Preguntas frecuentes</a></li>
                        <li><a href="../view/contacto.html">Contacto</a></li>
                    </ul>
                </div>
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Empresa</h4>
                    <ul>
                        <li><a href="../view/about-us.html">Sobre nosotros</a></li>
                        <li><a href="../view/Ignacio.html">Ignacio Breñas</a></li>
                        <li><a href="../view/Gorka.html">Gorka Ramírez</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>