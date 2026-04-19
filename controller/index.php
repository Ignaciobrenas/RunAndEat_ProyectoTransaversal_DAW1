<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$logueado = isset($_SESSION["id_usuario"]);
$nombre   = $logueado ? htmlspecialchars(explode(" ", $_SESSION["nombre_completo"])[0]) : "";
$foto     = $logueado ? htmlspecialchars($_SESSION["foto_perfil"]) : "";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Run & Eat - Eventos Gastronómicos</title>
    <link rel="icon" type="image/png" href="../public/img/logo.png">
    <link rel="stylesheet" href="../public/style/styles.css">
    <style>
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-menu .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #FFA208;
        }

        .user-menu .user-name {
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-menu .dropdown {
            display: none;
            position: absolute;
            top: 52px;
            right: 0;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .4);
            min-width: 170px;
            z-index: 999;
            overflow: hidden;
        }

        .user-menu:hover .dropdown {
            display: block;
        }

        .user-menu .dropdown a,
        .user-menu .dropdown button {
            display: block;
            width: 100%;
            padding: 11px 16px;
            text-align: left;
            background: none;
            border: none;
            font-size: 0.88rem;
            color: #ccc;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .user-menu .dropdown a:hover,
        .user-menu .dropdown button:hover {
            background: #2a2a2a;
            color: #FFA208;
        }

        .user-menu .dropdown .dropdown-divider {
            border: none;
            border-top: 1px solid #2a2a2a;
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo-section">
                <img src="../public/img/logo.png" alt="Run & Eat" onclick="location.href='index.php'">
                <div class="nav-left">
                    <button onclick="location.href='index.php'">Eventos</button>
                    <button onclick="location.href='../view/contacto.html'">Contacto</button>
                </div>
            </div>
            <div class="nav-right">
                <?php if ($logueado): ?>

                    <?php if ($_SESSION["tipo_usuario"] === "organizador"): ?>
                        <a href="../controller/crear-evento.php" class="organizer-link">Crear evento</a>
                    <?php endif; ?>

                    <button class="btn-login" onclick="location.href='perfil.php'">Mi perfil</button>

                <?php else: ?>

                    <a href="crear-evento.php" class="organizer-link">¿Eres organizador?</a>
                    <button class="btn-registro" onclick="location.href='registro.php'">REGISTRO</button>
                    <button class="btn-login" onclick="location.href='login.php'">INICIAR SESIÓN</button>

                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <section class="search-section">
            <div class="search-container search-dropdown">
                <div class="location-icon">Buscar</div>
                <input type="text" class="search-input" placeholder="Barcelona" autocomplete="off">
                <button class="filter-icon"><img src="../public/svg/busqueda-de-lupa.svg" alt="Buscar"></button>
            </div>
        </section>

        <section class="eventos-container">
            <div class="eventos-grid">

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

                <div class="evento-card">
                    <div class="evento-image">
                        <img src="../public/img/user.png" alt="Evento 1">
                    </div>
                    <div class="evento-content">
                        <h3 class="evento-title">Burger Run Barcelona</h3>
                        <p class="evento-description">Local con hamburguesas artesanas y opciones veganas. Buena música
                            y precios razonables. Usar Run and Eat me ayudó a decidirme y reservar sin complicaciones.</p>
                        <div class="evento-stars">★★★★★</div>
                        <button class="evento-button" onclick="location.href='../view/evento.html'">Ver Detalles</button>
                    </div>
                </div>

            </div>

            <!-- Paginación -->
            <div class="pagination">
                <button disabled>&lt;</button>
                <span class="page-number">1</span>
                <span class="page-info">de 5</span>
                <button>&gt;</button>
            </div>
        </section>
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
                        <li><a href="index.php">Eventos</a></li>
                        <li><a href="../controller/crear-evento.php">Crear evento</a></li>
                        <?php if (!$logueado): ?>
                            <li><a href="../controller/registro.php">Registro</a></li>
                            <li><a href="../controller/login.php">Iniciar sesión</a></li>
                        <?php endif; ?>
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