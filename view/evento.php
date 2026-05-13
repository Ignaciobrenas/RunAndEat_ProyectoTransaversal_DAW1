<?php
require_once "../controller/EventController.php";

$idEvento = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$eventController = new EventController();
$evento = $eventController->verEvento($idEvento);

if (!$evento) {
    die("Evento no encontrado o inactivo. <a href='../controller/index.php'>Volver a eventos</a>");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($evento['titulo']) ?> - Run & Eat</title>
    <link rel="icon" type="image/png" href="../public/img/logo.png">
    <link rel="stylesheet" href="../public/style/styles.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo-section">
                <img src="../public/img/logo.png" alt="Run & Eat" onclick="location.href='../controller/index.php'">
                <div class="nav-left">
                    <button onclick="location.href='../controller/index.php'">Eventos</button>
                    <button onclick="location.href='contacto.html'">Contacto</button>
                </div>
            </div>
            <div class="nav-right">
                <a href="../controller/crear-evento.php" class="organizer-link">¿Eres organizador?</a>
                <button class="btn-registro" onclick="location.href='../controller/registro.php'">REGISTRO</button>
                <button class="btn-login" onclick="location.href='../controller/login.php'">INICIAR SESIÓN</button>
            </div>
        </div>
    </header>

    <main>
        <div class="evento-detail-container">
            <div class="evento-detail-header">
                <div class="evento-detail-image">
                    <img src="../<?= htmlspecialchars($evento['imagen'] ?? 'public/img/eventos-photos/user.png') ?>" alt="<?= htmlspecialchars($evento['titulo']) ?>">
                </div>
                <div class="evento-detail-content">
                    <h1 class="evento-detail-title"><?= htmlspecialchars($evento['titulo']) ?></h1>
                    
                    <div class="evento-detail-meta">
                        <div class="meta-item">
                            <span class="meta-icon">¿Cuándo? </span>
                            <span><?= htmlspecialchars(date('d/m/Y', strtotime($evento['fecha']))) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">¿A qué hora?</span>
                            <span><?= htmlspecialchars(date('H:i', strtotime($evento['hora']))) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">¿Dónde? </span>
                            <span><?= htmlspecialchars($evento['ciudad']) ?>, <?= htmlspecialchars($evento['pais'] ?? 'España') ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-icon">¿Cuánta gente puede asistir?</span>
                            <span><?= htmlspecialchars($evento['capacidad']) ?> participantes (<?= htmlspecialchars($evento['plazas_disponibles']) ?> plazas disponibles)</span>
                        </div>
                    </div>

                    <div class="evento-stars">
                        <?php
                            $estrellas = (int)round($evento['valoracion_promedio'] ?? 0);
                            echo str_repeat("★", $estrellas) . str_repeat("☆", 5 - $estrellas);
                        ?>
                    </div>

                    <p class="evento-detail-description">
                        <?= nl2br(htmlspecialchars($evento['descripcion'])) ?>
                    </p>

                    <div class="evento-detail-info">
                        <h3 style="color: #FFA208; margin-bottom: 20px;">Información del Evento</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <h4>Precio</h4>
                                <p><?= htmlspecialchars($evento['precio']) ?>€ por persona</p>
                            </div>
                            <?php if (!empty($evento['distancia'])): ?>
                            <div class="info-item">
                                <h4>Distancia</h4>
                                <p><?= htmlspecialchars($evento['distancia']) ?> kilómetros</p>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($evento['nivel'])): ?>
                            <div class="info-item">
                                <h4>Nivel</h4>
                                <p><?= htmlspecialchars($evento['nivel']) ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($evento['que_incluye'])): ?>
                            <div class="info-item">
                                <h4>Incluye</h4>
                                <p><?= htmlspecialchars($evento['que_incluye']) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="evento-detail-actions">
                        <button class="btn-primary">Apuntarse al Evento</button>
                        <button class="btn-share">Compartir</button>
                    </div>
                </div>
            </div>

            <div class="evento-organizer">
                <h3>Organizador</h3>
                <div class="organizer-info">
                    <img src="../<?= htmlspecialchars($evento['organizador_foto'] ?? 'public/img/user-photos/user.png') ?>" alt="Organizador" class="organizer-image">
                    <div class="organizer-details">
                        <h4><?= htmlspecialchars($evento['organizador_nombre'] ?? 'Organizador Desconocido') ?></h4>
                        <p>Organizador de eventos gastronómicos y deportivos</p>
                    </div>
                </div>
            </div>


            <div class="evento-organizer" style="margin-top: 30px;">
                <h3>Ubicación</h3>
                <div style="color: #ffffff; margin-top: 15px;">
                    <p><strong style="color: #fff;">Dirección:</strong> <?= htmlspecialchars($evento['direccion_completa']) ?>, <?= htmlspecialchars($evento['ciudad']) ?></p>
                </div>
                
                <div class="map-container" style="margin-top: 20px;">
                    <iframe 
                        src="https://www.google.com/maps?q=<?= urlencode($evento['direccion_completa'] . ', ' . $evento['ciudad']) ?>&output=embed" 
                        width="100%" 
                        height="300"
                        style="border:0; border-radius: 8px;"
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                

                <a href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($evento['direccion_completa'] . ', ' . $evento['ciudad']) ?>" 
                   target="_blank" 
                   class="btn-google-maps"
                   style="margin-top: 15px; display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                    </svg>
                    Abrir en Google Maps
                </a>
            </div>

            <?php if (!empty($evento['que_traer'])): ?>

            <div class="evento-organizer" style="margin-top: 30px;">
                <h3>Qué Traer</h3>
                <div style="color: #ffffff; margin-top: 15px; line-height: 2;">
                    <p><?= nl2br(htmlspecialchars($evento['que_traer'])) ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($evento['notas_adicionales'])): ?>
            <div class="evento-organizer" style="margin-top: 30px;">
                <h3>Notas Adicionales</h3>
                <div style="color: #ffffff; margin-top: 15px; line-height: 2;">
                    <p><?= nl2br(htmlspecialchars($evento['notas_adicionales'])) ?></p>
                </div>
            </div>
            <?php endif; ?>

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
                        <li><a href="../controller/index.php">Eventos</a></li>
                        <li><a href="../controller/crear-evento.php">Crear evento</a></li>
                        <li><a href="../controller/registro.php">Registro</a></li>
                        <li><a href="../controller/login.php">Iniciar sesión</a></li>
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
