<?php
require_once "../controller/auth_guard.php";
require_once "../controller/EventController.php";

auth_require_role("organizador");

if (!isset($_GET['id'])) {
    header("Location: perfil.php");
    exit();
}

$id_evento = (int)$_GET['id'];
$eventCtrl = new EventController();
$evento = $eventCtrl->verEvento($id_evento);

if (!$evento) {
    $_SESSION["error"] = "Evento no encontrado.";
    header("Location: perfil.php");
    exit();
}

if ($evento['id_organizador'] != $_SESSION['id_usuario'] && $_SESSION['tipo_usuario'] !== 'admin') {
    $_SESSION["error"] = "No tienes permiso para editar este evento.";
    header("Location: perfil.php");
    exit();
}

$nombre = htmlspecialchars($_SESSION["nombre_completo"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento - Run & Eat</title>
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
        <div class="create-evento-container">
            <?php if (isset($_SESSION["success"])): ?>
                <div class="alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center;">
                    <?= $_SESSION["success"] ?>
                </div>
                <?php unset($_SESSION["success"]); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION["error"])): ?>
                <div class="alert-error" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 4px; text-align: center;">
                    <?= $_SESSION["error"] ?>
                </div>
                <?php unset($_SESSION["error"]); ?>
            <?php endif; ?>

            <div class="create-evento-form">
                <h2>Editar Evento: <?= htmlspecialchars($evento['titulo']) ?></h2>
                <p>Modifica la información de tu evento gastronómico</p>
                
                <form method="POST" action="../controller/EventController.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="modificarEvento">
                    <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">

                    <div class="form-section">
                        <h3>Información Básica</h3>
                        
                        <div class="form-group">
                            <label for="titulo">Título del Evento</label>
                            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($evento['titulo']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($evento['descripcion']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Imagen del Evento (Deja vacío para mantener la actual)</label>
                            <div class="file-upload" onclick="document.getElementById('file-input').click()">
                                <div class="upload-icon"></div>
                                <div class="upload-text">Haz clic para subir una nueva imagen</div>
                                <input type="file" id="file-input" name="imagen" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <?php if ($evento['imagen']): ?>
                                <p style="margin-top: 10px; font-size: 14px; color: #666;">Imagen actual: <img src="../<?= htmlspecialchars($evento['imagen']) ?>" alt="Imagen evento" style="max-width: 100px; max-height: 100px; display: block; margin-top: 5px; border-radius: 8px;"></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Fecha y Ubicación</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($evento['fecha']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="hora">Hora de Inicio</label>
                                <input type="time" id="hora" name="hora" value="<?= htmlspecialchars($evento['hora']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" id="ubicacion" name="ubicacion" value="<?= htmlspecialchars($evento['ciudad']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección Completa</label>
                            <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($evento['direccion_completa']) ?>" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Detalles del Evento</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="precio">Precio (€)</label>
                                <input type="number" id="precio" name="precio" value="<?= htmlspecialchars($evento['precio']) ?>" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="participantes">Número de Participantes</label>
                                <input type="number" id="participantes" name="participantes" value="<?= htmlspecialchars($evento['capacidad']) ?>" min="1" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="distancia">Distancia (km)</label>
                                <input type="number" id="distancia" name="distancia" value="<?= htmlspecialchars($evento['distancia'] ?? '') ?>" min="0" step="0.1">
                            </div>
                            <div class="form-group">
                                <label for="nivel">Nivel</label>
                                <select id="nivel" name="nivel" required>
                                    <option value="">Selecciona un nivel</option>
                                    <option value="principiante" <?= $evento['nivel'] === 'principiante' ? 'selected' : '' ?>>Principiante</option>
                                    <option value="intermedio" <?= $evento['nivel'] === 'intermedio' ? 'selected' : '' ?>>Intermedio</option>
                                    <option value="avanzado" <?= $evento['nivel'] === 'avanzado' ? 'selected' : '' ?>>Avanzado</option>
                                    <option value="todos" <?= $evento['nivel'] === 'todos' ? 'selected' : '' ?>>Todos los niveles</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo-evento">Tipo de Evento</label>
                            <select id="tipo-evento" name="tipo-evento" required>
                                <option value="">Selecciona el tipo</option>
                                <?php
                                $listaCategorias = $eventCtrl->getCategorias();
                                foreach ($listaCategorias as $cat) {
                                    $selected = ($cat['id_categoria'] == $evento['id_categoria']) ? 'selected' : '';
                                    echo '<option value="' . $cat['id_categoria'] . '" ' . $selected . '>' . htmlspecialchars($cat['nombre']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="incluye">Qué Incluye</label>
                            <input type="text" id="incluye" name="incluye" value="<?= htmlspecialchars($evento['que_incluye'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Información Adicional</h3>
                        
                        <div class="form-group">
                            <label for="que-traer">Qué Traer</label>
                            <textarea id="que-traer" name="que-traer"><?= htmlspecialchars($evento['que_traer'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="notas">Notas Adicionales</label>
                            <textarea id="notas" name="notas"><?= htmlspecialchars($evento['notas_adicionales'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Guardar Cambios</button>
                    <a href="perfil.php" style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">Cancelar</a>
                </form>
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

    <script src="../public/scripts/script.js"></script>
</body>
</html>
