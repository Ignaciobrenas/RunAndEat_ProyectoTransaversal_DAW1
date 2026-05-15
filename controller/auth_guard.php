<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function auth_require_login(): void
{
    if (!isset($_SESSION["id_usuario"])) {
        header("Location: ../view/login.php");
        exit();
    }
}

function auth_require_role(string $rol): void
{
    auth_require_login();

    if ($_SESSION["tipo_usuario"] !== $rol) {
        auth_show_forbidden();
    }
}


function auth_is(string $rol): bool
{
    return isset($_SESSION["tipo_usuario"]) && $_SESSION["tipo_usuario"] === $rol;
}


function auth_check(): bool
{
    return isset($_SESSION["id_usuario"]);
}


function auth_show_forbidden(): void
{
    $nombre = htmlspecialchars(explode(" ", $_SESSION["nombre_completo"] ?? "")[0]);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso restringido - Run & Eat</title>
        <link rel="icon" type="image/png" href="../public/img/logo.png">
        <link rel="stylesheet" href="../public/style/styles.css">
        
    </head>
    <body>
        <header>
            <div class="header-container">
                <div class="logo-section">
                    <img src="../public/img/logo.png" alt="Run & Eat" onclick="location.href='../index.php'">
                    <div class="nav-left">
                        <button onclick="location.href='../index.php'">Eventos</button>
                        <button onclick="location.href='../view/contacto.html'">Contacto</button>
                    </div>
                </div>
                <div class="nav-right">
                    <form method="POST" action="../controller/UserController.php">
                        <button type="submit" name="logout" class="btn-login">CERRAR SESIÓN</button>
                    </form>
                </div>
            </div>
        </header>

        <main>
            <div class="forbidden-wrapper">
                <div class="forbidden-card">
                    <div class="forbidden-icon">ACCESO RESTRINGIDO</div>
                    <h2>Área de organizadores</h2>
                    <p>Hola <span><?= $nombre ?></span>, esta sección es exclusiva para organizadores.</p>
                    <p>Si quieres crear y gestionar eventos en Run &amp; Eat, ponte en contacto con nosotros y te activamos el acceso.</p>
                    <div class="forbidden-actions">
                        <a href="../view/contacto.html" class="btn-contacto-problema">Quiero ser organizador</a>
                        <a href="../index.php" class="btn-backo">← Volver a los eventos</a>
                    </div>
                </div>
            </div>
        </main>

        <footer class="site-footer"></footer>
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
                        <li><a href="../view/crear-evento.php ">Crear evento</a></li>
                        <li><a href="../view/registro.php">Registro</a></li>
                        <li><a href="../view/login.php">Iniciar sesión</a></li>
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

    <script src="../public/scripts/script.js"></script>
</body>
</html>
    <?php
    exit();
}
