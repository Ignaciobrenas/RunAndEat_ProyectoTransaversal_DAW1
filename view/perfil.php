<?php
require_once "../controller/UserController.php";

$controller = new UserController();
$data = $controller->getProfileData();

$usuario         = $data["usuario"];
$eventos_usuario = $data["eventos_usuario"];
$foto_src        = $data["foto_src"];
$fecha_registro  = $data["fecha_registro"];

$mensaje_ok    = $_SESSION["success"] ?? "";
$mensaje_error = $_SESSION["error"]   ?? "";
unset($_SESSION["success"], $_SESSION["error"]);
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
                     onclick="location.href='../index.php'">
                <div class="nav-left">
                    <button onclick="location.href='../index.php'">Eventos</button>
                    <button onclick="location.href='contacto.html'">Contacto</button>
                </div>
            </div>
            <div class="nav-right">
                <button class="btn-registro" onclick="location.href='perfil.php'">MI PERFIL</button>
                <form method="POST" action="../controller/UserController.php" style="display:inline;">
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

                    <form method="POST" action="../controller/UserController.php" enctype="multipart/form-data">
                        <input type="hidden" name="update_photo" value="1">

                        <div class="foto-form-wrap">
                            <div class="perfil-image-container">
                                <img src="<?= $foto_src ?>" alt="Foto de perfil" class="perfil-image">


                                <label for="foto_perfil_input" class="change-photo-btn">Cambiar</label>
                                <input type="file" id="foto_perfil_input" name="foto_perfil"
                                       accept="image/jpeg,image/png,image/webp,image/gif"
                                       onchange="this.form.submit()">
                            </div>
                            <noscript><button type="submit" class="btn-subir-foto">Subir foto</button></noscript>
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
                    <form method="POST" action="../controller/UserController.php">
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
                    <form method="POST" action="../controller/UserController.php">
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

                <!-- Eliminar Cuenta -->
                <div class="perfil-section">
                    <h3>Eliminar Cuenta</h3>
                    <p style="color: #ccc; font-size: 0.9rem; margin-bottom: 15px;">
                        Esta acción es permanente y no se puede deshacer. Se borrarán todos tus datos, eventos e inscripciones.
                    </p>
                    <form method="POST" action="../controller/UserController.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta permanentemente?');">
                        <div class="form-group">
                            <label for="password-confirm">Confirma tu contraseña para borrar la cuenta</label>
                            <input type="password" id="password-confirm" name="password" placeholder="••••••••" required>
                        </div>
                        <button type="submit" name="delete_account" class="btn-submit">
                            Eliminar Mi Cuenta
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
                                 onclick="location.href='../view/evento.php?id=<?= $ev['id_evento'] ?>'"
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
                        <li><a href="../index.php">Eventos</a></li>
                        <li><a href="crear-evento.html">Crear evento</a></li>
                        <li><a href="registro.php">Registro</a></li>
                        <li><a href="login.php">Iniciar sesión</a></li>
                    </ul>
                </div>
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Soporte</h4>
                    <ul>
                        <li><a href="faq.html">Preguntas frecuentes</a></li>
                        <li><a href="contacto.html">Contacto</a></li>
                    </ul>
                </div>
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Empresa</h4>
                    <ul>
                        <li><a href="about-us.html">Sobre nosotros</a></li>
                        <li><a href="Ignacio.html">Ignacio Breñas</a></li>
                        <li><a href="Gorka.html">Gorka Ramírez</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>