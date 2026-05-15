<?php
session_start();

if (isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit();
}

// Recoger mensajes de sesión
$error   = $_SESSION["error"]   ?? "";
$success = isset($_GET["registered"]) ? "Cuenta creada correctamente. Ya puedes iniciar sesión." : "";
unset($_SESSION["error"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Run & Eat</title>
    <link rel="icon" type="image/png" href="../public/img/logo.png">
    <link rel="stylesheet" href="../public/style/styles.css">
    <style>
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 14px; font-size: 0.9rem; }
        .alert-error   { background: #fdecea; color: #c0392b; border: 1px solid #f5c6cb; }
        .alert-success { background: #eafaf1; color: #1e8449; border: 1px solid #a9dfbf; }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo-section">
                <img src="../public/img/logo.png" alt="Run & Eat" onclick="location.href='../index.php'">
                <div class="nav-left">
                    <button onclick="location.href='../index.php'">Eventos</button>
                    <button onclick="location.href='contacto.html'">Contacto</button>
                </div>
            </div>
            <div class="nav-right">
                <a href="crear-evento.php" class="organizer-link">¿Eres organizador?</a>
                <button class="btn-registro" onclick="location.href='registro.php'">REGISTRO</button>
            </div>
        </div>
    </header>

    <main>
        <div class="auth-container">
            <div class="auth-form">
                <h2>Iniciar Sesión</h2>
                <p>Accede a tu cuenta de Run &amp; Eat</p>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="../controller/UserController.php">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               placeholder="Correo Electrónico" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena"
                               placeholder="••••••••" required autocomplete="current-password">
                    </div>

             
                    <button type="submit" name="login" class="btn-submit">Iniciar Sesión</button>
                </form>

                <div class="auth-footer">
                    ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
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
                        <li><a href="crear-evento.php">Crear evento</a></li>
                        <li><a href="registro.php">Registro</a></li>
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

    <script src="../public/scripts/script.js"></script>
</body>
</html>