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
    <link rel="icon" type="image/png" href="public/img/logo.png">
    <link rel="stylesheet" href="public/style/styles.css">
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
    <link rel="stylesheet" type="text/css" href="public/scripts/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="public/scripts/slick/slick-theme.css"/>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo-section">
                <img src="public/img/logo.png" alt="Run & Eat" onclick="location.href='index.php'">
                <div class="nav-left">
                    <button onclick="location.href='index.php'">Eventos</button>
                    <button onclick="location.href='view/contacto.html'">Contacto</button>
                </div>
            </div>
            <div class="nav-right">
                <?php if ($logueado): ?>

                    <?php if ($_SESSION["tipo_usuario"] === "organizador"): ?>
                        <a href="view/crear-evento.php" class="organizer-link">Crear evento</a>
                    <?php endif; ?>

                    <button class="btn-login" onclick="location.href='view/perfil.php'">Mi perfil</button>

                <?php else: ?>

                    <a href="view/crear-evento.php" class="organizer-link">¿Eres organizador?</a>
                    <button class="btn-registro" onclick="location.href='view/registro.php'">REGISTRO</button>
                    <button class="btn-login" onclick="location.href='view/login.php'">INICIAR SESIÓN</button>

                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION["success"])): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px auto; max-width: 1200px; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center;">
                <?= $_SESSION["success"] ?>
            </div>
            <?php unset($_SESSION["success"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["error"])): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin: 20px auto; max-width: 1200px; border: 1px solid #f5c6cb; border-radius: 4px; text-align: center;">
                <?= $_SESSION["error"] ?>
            </div>
            <?php unset($_SESSION["error"]); ?>
        <?php endif; ?>

        <section class="search-section">
            <div class="search-container search-dropdown">
                <div class="location-icon">Buscar</div>
                <input type="text" class="search-input" placeholder="Barcelona" autocomplete="off">
                <button class="filter-icon"><img src="public/svg/busqueda-de-lupa.svg" alt="Buscar"></button>
            </div>
        </section>

        <section class="eventos-container">
            <?php
            require_once "controller/EventController.php";
            $eventCtrl = new EventController();
            $eventos = $eventCtrl->listarEventos();
            ?>

            <h2 class="section-title">Organizadores destacados</h2>
            <div class="organizadores-carousel">
                <?php
                $organizadores = $eventCtrl->listarOrganizadoresDestacados();
                if (empty($organizadores)):
                ?>
                    <p style="color:white;">No hay organizadores disponibles en este momento.</p>
                <?php else: ?>
                    <?php foreach ($organizadores as $org): ?>
                        <div class="slick-item-wrapper">
                            <div class="organizador-card">
                                <div class="organizador-avatar-wrapper">
                                    <img src="<?= htmlspecialchars(!empty($org['foto_perfil']) ? $org['foto_perfil'] : 'public/img/user.png') ?>" alt="<?= htmlspecialchars($org['nombre_completo']) ?>" class="organizador-avatar">
                                </div>
                                <h3 class="organizador-name"><?= htmlspecialchars($org['nombre_completo']) ?></h3>
                                <p class="organizador-role">Organizador Profesional</p>
                                <div class="organizador-badge">
                                    <?= htmlspecialchars($org['total_eventos']) ?> <?= $org['total_eventos'] == 1 ? 'evento creado' : 'eventos creados' ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <h2 class="section-title" style="margin-top: 4rem;">Eventos destacados</h2>
            <div class="eventos-carousel">
                <?php if (empty($eventos)): ?>
                    <p style="color:white;">No hay eventos disponibles en este momento.</p>
                <?php else: ?>
                    <?php foreach ($eventos as $evento): ?>
                        <div class="slick-item-wrapper">
                            <div class="evento-card">
                                <div class="evento-image">
                                    <!-- Asumiendo que la imagen guardada en BD es algo como 'public/img/eventos-photos/user.png' -->
                                    <img src="<?= htmlspecialchars($evento['imagen'] ?? 'public/img/eventos-photos/user.png') ?>" alt="<?= htmlspecialchars($evento['titulo']) ?>">
                                    <div class="evento-price-badge">
                                        <?= $evento['precio'] > 0 ? number_format($evento['precio'], 2) . '€' : 'Gratis' ?>
                                    </div>
                                </div>
                                <div class="evento-content">
                                    <h3 class="evento-title"><?= htmlspecialchars($evento['titulo']) ?></h3>
                                    <p class="evento-description"><?= htmlspecialchars(mb_substr($evento['descripcion'], 0, 150)) ?>...</p>
                                    
                                    <div class="evento-author">
                                        <img src="<?= htmlspecialchars(!empty($evento['organizador_foto']) ? $evento['organizador_foto'] : 'public/img/user.png') ?>" alt="<?= htmlspecialchars($evento['organizador_nombre'] ?? 'Organizador') ?>" class="evento-author-img">
                                        <span class="evento-author-name">Por <span class="highlight"><?= htmlspecialchars($evento['organizador_nombre'] ?? 'Organizador') ?></span></span>
                                    </div>

                                    <div class="evento-stars">
                                        <?php
                                            $estrellas = (int)round($evento['valoracion_promedio'] ?? 0);
                                            echo str_repeat("★", $estrellas) . str_repeat("☆", 5 - $estrellas);
                                        ?>
                                    </div>
                                    <button class="evento-button" onclick="location.href='view/evento.php?id=<?= $evento['id_evento'] ?>'">Ver Detalles</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="site-footer__inner">
            <div class="site-footer__brand">
                <img src="public/img/logo.png" alt="Run & Eat" class="site-footer__logo">
                <p class="site-footer__tagline">La plataforma de eventos gastronómicos.</p>
                <p class="site-footer__copy">&copy; 2026 Run &amp; Eat. Todos los derechos reservados.</p>
            </div>
            <div class="site-footer__nav">
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Plataforma</h4>
                    <ul>
                        <li><a href="index.php">Eventos</a></li>
                        <li><a href="view/crear-evento.php">Crear evento</a></li>
                        <?php if (!$logueado): ?>
                            <li><a href="view/registro.php">Registro</a></li>
                            <li><a href="view/login.php">Iniciar sesión</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Soporte</h4>
                    <ul>
                        <li><a href="view/faq.html">Preguntas frecuentes</a></li>
                        <li><a href="view/contacto.html">Contacto</a></li>
                    </ul>
                </div>
                <div class="site-footer__col">
                    <h4 class="site-footer__col-title">Empresa</h4>
                    <ul>
                        <li><a href="view/about-us.html">Sobre nosotros</a></li>
                        <li><a href="view/Ignacio.html">Ignacio Breñas</a></li>
                        <li><a href="view/Gorka.html">Gorka Ramírez</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="public/scripts/jquery-1.12.4.js"></script>
    <script src="public/scripts/slick/slick.min.js"></script>
    <script src="public/scripts/script.js"></script>
</body>

</html>