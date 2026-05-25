// Manejo del desplegable de filtros
document.addEventListener('DOMContentLoaded', function () {
    // Elementos del DOM
    const filterBtn = document.querySelector('.filter-icon');
    const searchContainer = document.querySelector('.search-container');

    // Crear el dropdown de filtros si estamos en la página de eventos
    if (filterBtn && searchContainer) {
        createFilterDropdown();

        filterBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const dropdown = document.querySelector('.filter-dropdown');
            dropdown.classList.toggle('active');
        });

        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function (e) {
            const dropdown = document.querySelector('.filter-dropdown');
            if (dropdown && !searchContainer.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }

    // Inicializar sliders
    initializeRangeSliders();

    // carrusel de eventos 
    if ($('.eventos-carousel').length > 0) {
        $('.eventos-carousel').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            centerMode: false,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false
                    }
                }
            ]
        });
    }

    // carrusel de organizadores destacados
    if ($('.organizadores-carousel').length > 0) {
        $('.organizadores-carousel').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3500,
            centerMode: false,
            adaptiveHeight: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false
                    }
                }
            ]
        });
    }

    // Interactivitat dels botons del detall de l'event (Apuntarse i Compartir)
    if (typeof jQuery !== 'undefined') {
        // Botó "Apuntarse al Evento"
        jQuery('.evento-detail-actions .btn-primary').not('[onclick]').on('click', function (e) {
            e.preventDefault();
            showCustomModal(
                '¡Inscripción Completada!',
                'Te has apuntado correctamente a este evento gastronómico. Recibirás un email con todos los detalles pronto. ¡Que aproveche!',
                'success'
            );
        });

        // Botó "Compartir"
        jQuery('.evento-detail-actions .btn-share').on('click', function (e) {
            e.preventDefault();
            var currentUrl = window.location.href;
            showCustomModal(
                'Compartir Evento',
                'Copia este enlace para compartirlo con tus amigos:<br><br><strong style="color:#FFA208;word-break:break-all;">' + currentUrl + '</strong>',
                'share'
            );
        });

        // Formulario de contacto
        jQuery('.contact-form form').on('submit', function (e) {
            e.preventDefault();
            showCustomModal(
                '¡Mensaje Enviado!',
                'Gracias por contactar con Run & Eat. Hemos recibido tu mensaje y te responderemos lo antes posible.',
                'success'
            );
            this.reset();
        });

        // ============================================================
        // MISSATGE DESPLEGABLE SOBRE IMATGES (HOVER EFFECT) WITH JQUERY
        // ============================================================
        
        // Assegurem que els contenidors de les imatges tinguin position: relative i overflow: hidden
        var $hoverTargets = jQuery('.evento-image img, .evento-detail-image img, .aboutus-member__photo, img.hover-msg-trigger');
        
        $hoverTargets.each(function() {
            var $img = jQuery(this);
            var $container = $img.parent();
            
            // Si el contenidor és un enllaç o un div simple, ens assegurem que estigui preparat
            $container.css({
                'position': 'relative',
                'overflow': 'hidden',
                'display': $container.css('display') === 'inline' ? 'inline-block' : $container.css('display')
            });
            
            // Afegim una classe per si cal algun estil addicional
            $container.addClass('hover-msg-container');
        });

        // Event quan el ratolí es situa a sobre de la imatge
        jQuery(document).on('mouseenter', '.evento-image img, .evento-detail-image img, .aboutus-member__photo, img.hover-msg-trigger', function() {
            var $img = jQuery(this);
            var $container = $img.parent();
            
            // Evitar duplicats
            if ($container.find('.image-hover-msg').length > 0) {
                return;
            }
            
            // Determinar el missatge i icona segons el context
            var msgText = "¡Clica per a conèixer tots els detalls!";
            var icon = "✨";
            var title = "Run & Eat";
            
            if ($img.closest('.evento-card').length > 0) {
                msgText = "¡Descobreix tots els detalls d'aquest esdeveniment gastronòmic!";
                icon = "🍽️";
                title = "Esdeveniment";
            } else if ($img.closest('.evento-detail-image').length > 0) {
                msgText = "¡Revisa la ubicació, preu i reserva la teva plaça!";
                icon = "📍";
                title = "Detalls";
            } else if ($img.hasClass('aboutus-member__photo') || $img.closest('.aboutus-member').length > 0) {
                msgText = "¡Clica per a veure el perfil complet d'aquest cofundador!";
                icon = "👨‍🍳";
                title = "Cofundador";
            }
            
            // Permetre personalitzar via atributs de dades de la imatge
            if ($img.data('hover-msg')) { msgText = $img.data('hover-msg'); }
            if ($img.data('hover-icon')) { icon = $img.data('hover-icon'); }
            if ($img.data('hover-title')) { title = $img.data('hover-title'); }
            
            // Crear l'overlay del missatge amb jQuery
            var $overlay = jQuery(
                '<div class="image-hover-msg">' +
                    '<div class="hover-msg-inner">' +
                        '<span class="hover-msg-icon">' + icon + '</span>' +
                        '<h4 class="hover-msg-title">' + title + '</h4>' +
                        '<p class="hover-msg-text">' + msgText + '</p>' +
                    '</div>' +
                '</div>'
            );
            
            $container.append($overlay);
            
            // Desplegar (slide down) amb jQuery animate
            $overlay.stop().animate({ 'top': '0%' }, 450, 'swing', function() {
                // Activar l'animació de text/icona una vegada desplegat
                $overlay.find('.hover-msg-inner').css({
                    'transform': 'translateY(0)',
                    'opacity': '1'
                });
            });
            
            // Event quan el ratolí marxi de sobre el missatge
            $overlay.on('mouseleave', function() {
                var $activeOverlay = jQuery(this);
                // Ocultar text primer
                $activeOverlay.find('.hover-msg-inner').css({
                    'transform': 'translateY(-20px)',
                    'opacity': '0'
                });
                // Plegar cap a dalt amb jQuery animate i eliminar del DOM
                $activeOverlay.stop().animate({ 'top': '-100%' }, 400, 'swing', function() {
                    $activeOverlay.remove();
                });
            });
            
            // Si es fa clic a sobre de l'overlay, redirigir correctament
            $overlay.on('click', function(e) {
                // Si és una targeta d'esdeveniment, redirigir cap a la pàgina de l'esdeveniment
                var $evCard = $img.closest('.evento-card');
                if ($evCard.length > 0) {
                    var btnUrl = $evCard.find('.evento-button').attr('onclick');
                    if (btnUrl) {
                        var match = btnUrl.match(/location\.href\s*=\s*['"]([^'"]+)['"]/);
                        if (match && match[1]) {
                            window.location.href = match[1];
                            return;
                        }
                    }
                }
                
                // Si és un membre d'about-us, redirigir
                var $memberCard = $img.closest('.aboutus-member');
                if ($memberCard.length > 0) {
                    var $btn = $memberCard.find('.aboutus-member__btn, .aboutus-member__btn--outline');
                    var btnUrl = $btn.attr('onclick');
                    if (btnUrl) {
                        var match = btnUrl.match(/location\.href\s*=\s*['"]([^'"]+)['"]/);
                        if (match && match[1]) {
                            window.location.href = match[1];
                            return;
                        }
                    }
                }

                // Propagar clic general a la imatge original
                $img.trigger('click');
            });
        });
    }
});

// Crear el dropdown de filtros
function createFilterDropdown() {
    const searchContainer = document.querySelector('.search-container');

    const filterHTML = `
        <div class="filter-dropdown">
            <!-- Filtro por Ciudad -->
            <div class="filter-section">
                <h3>Ciudad</h3>
                <label for="filter-ciudad">Selecciona una ciudad</label>
                <select id="filter-ciudad" name="ciudad">
                    <option value="">Todas las ciudades</option>
                    <option value="barcelona">Barcelona</option>
                    <option value="madrid">Madrid</option>
                    <option value="valencia">Valencia</option>
                    <option value="sevilla">Sevilla</option>
                    <option value="malaga">Málaga</option>
                    <option value="bilbao">Bilbao</option>
                    <option value="zaragoza">Zaragoza</option>
                </select>
            </div>
            
            <!-- Filtro por Precio -->
            <div class="filter-section">
                <h3>Precio</h3>
                <label for="filter-precio">Precio máximo: <span class="range-value" id="precio-value">50€</span></label>
                <div class="range-container">
                    <input type="range" id="filter-precio" name="precio" min="0" max="100" value="50" step="5" class="range-slider">
                </div>
            </div>
            
            <!-- Filtro por Distancia -->
            <div class="filter-section">
                <h3>Distancia</h3>
                <label for="filter-distancia">Distancia máxima: <span class="range-value" id="distancia-value">10 km</span></label>
                <div class="range-container">
                    <input type="range" id="filter-distancia" name="distancia" min="0" max="25" value="10" step="1" class="range-slider">
                </div>
            </div>
            
            <!-- Filtro por Tipo de Evento -->
            <div class="filter-section">
                <h3>Tipo de Evento</h3>
                <label for="filter-tipo">Selecciona el tipo de evento</label>
                <select id="filter-tipo" name="tipo">
                    <option value="">Todos los tipos</option>
                    <option value="cata-vino">Cata de Vino</option>
                    <option value="hamburguesas">Hamburguesas</option>
                    <option value="restaurante">Restaurante</option>
                    <option value="bar">Bar / Tapas</option>
                    <option value="comida-china">Comida China</option>
                    <option value="comida-mexicana">Comida Mexicana</option>
                    <option value="comida-filipina">Comida Filipina</option>
                    <option value="comida-italiana">Comida Italiana</option>
                    <option value="comida-japonesa">Comida Japonesa</option>
                    <option value="comida-india">Comida India</option>
                    <option value="cafeteria">Cafetería</option>
                    <option value="pizzeria">Pizzería</option>
                    <option value="sushi">Sushi</option>
                    <option value="tacos">Tacos</option>
                    <option value="vegano">Opciones Veganas</option>
                    <option value="vegetariano">Opciones Vegetarianas</option>
                </select>
            </div>
            
            <!-- Botones de acción -->
            <div class="filter-buttons">
                <button type="button" class="btn-apply-filters" onclick="applyFilters()">Aplicar Filtros</button>
                <button type="button" class="btn-clear-filters" onclick="clearFilters()">Limpiar Filtros</button>
            </div>
        </div>
    `;

    searchContainer.insertAdjacentHTML('beforeend', filterHTML);
}

// Inicializar los sliders de rango
function initializeRangeSliders() {
    // Slider de precio
    const precioSlider = document.getElementById('filter-precio');
    const precioValue = document.getElementById('precio-value');

    if (precioSlider && precioValue) {
        precioSlider.addEventListener('input', function () {
            precioValue.textContent = this.value + '€';
        });
    }

    // Slider de distancia
    const distanciaSlider = document.getElementById('filter-distancia');
    const distanciaValue = document.getElementById('distancia-value');

    if (distanciaSlider && distanciaValue) {
        distanciaSlider.addEventListener('input', function () {
            distanciaValue.textContent = this.value + ' km';
        });
    }
}

// Aplicar filtros
function applyFilters() {
    const ciudad = document.getElementById('filter-ciudad')?.value || '';
    const precio = document.getElementById('filter-precio')?.value || '';
    const distancia = document.getElementById('filter-distancia')?.value || '';
    const tipo = document.getElementById('filter-tipo')?.value || '';

    console.log('Filtros aplicados:', {
        ciudad: ciudad,
        precioMax: precio,
        distanciaMax: distancia,
        tipo: tipo
    });

    // Aquí irá la lógica para filtrar los eventos
    // Por ahora solo mostramos un mensaje
    showCustomModal(
        '¡Filtros Aplicados!',
        'Los filtros se han aplicado correctamente. En la versión final con PHP, esto filtrará la lista de eventos.',
        'success'
    );

    // Cerrar el dropdown
    const dropdown = document.querySelector('.filter-dropdown');
    if (dropdown) {
        dropdown.classList.remove('active');
    }
}

// Limpiar filtros
function clearFilters() {
    const ciudadSelect = document.getElementById('filter-ciudad');
    const precioSlider = document.getElementById('filter-precio');
    const distanciaSlider = document.getElementById('filter-distancia');
    const tipoSelect = document.getElementById('filter-tipo');

    if (ciudadSelect) ciudadSelect.value = '';
    if (precioSlider) {
        precioSlider.value = 50;
        document.getElementById('precio-value').textContent = '50€';
    }
    if (distanciaSlider) {
        distanciaSlider.value = 10;
        document.getElementById('distancia-value').textContent = '10 km';
    }
    if (tipoSelect) tipoSelect.value = '';

    console.log('Filtros limpiados');
}

// Menú móvil
function toggleMobileMenu() {
    const mobileNav = document.querySelector('.mobile-nav');
    if (mobileNav) {
        mobileNav.classList.toggle('active');
    }
}

function closeMobileMenu() {
    const mobileNav = document.querySelector('.mobile-nav');
    if (mobileNav) {
        mobileNav.classList.remove('active');
    }
}

// Preview de imagen en formulario de crear evento
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const uploadText = input.parentElement.querySelector('.upload-text');
            if (uploadText) {
                uploadText.textContent = input.files[0].name;
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Validación de formularios (para cuando se añada PHP)
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = '#ff4444';
        } else {
            input.style.borderColor = '#233554';
        }
    });

    return isValid;
}

// Validar email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Validar contraseña (mínimo 8 caracteres)
function validatePassword(password) {
    return password.length >= 8;
}
document.querySelectorAll('.faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.faq-item');
        const isOpen = item.classList.contains('open');

        // Cerrar todos
        document.querySelectorAll('.faq-item.open').forEach(openItem => {
            openItem.classList.remove('open');
            openItem.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
        });

        // Abrir el clickado si estaba cerrado
        if (!isOpen) {
            item.classList.add('open');
            btn.setAttribute('aria-expanded', 'true');
        }
    });
});

// Filtro por categoría
document.querySelectorAll('.faq-cat-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.faq-cat-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const cat = btn.dataset.category;
        document.querySelectorAll('.faq-section').forEach(section => {
            if (cat === 'all' || section.dataset.category === cat) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });
});

// ============================================================
// MODAL PERSONALITZAT AMB JQUERY
// Mostra un missatge modal sobre un fons transparent.
// Al clicar el fons, el missatge s'oculta.
// ============================================================
function showCustomModal(title, message, iconType) {
    if (iconType === undefined) { iconType = 'info'; }

    // Fallback si jQuery no està disponible
    if (typeof jQuery === 'undefined') {
        alert(title + '\n\n' + message.replace(/<br>/g, '\n').replace(/<[^>]*>/g, ''));
        return;
    }

    var icons = { success: '✅', error: '❌', share: '🔗', info: 'ℹ️' };
    var iconHtml = icons[iconType] || icons['info'];

    // Construir el modal amb jQuery
    var $backdrop = jQuery('<div class="custom-modal-backdrop"></div>');
    var $content  = jQuery('<div class="custom-modal-content"></div>');
    var $closeBtn = jQuery('<button class="custom-modal-close">&times;</button>');
    var $body     = jQuery('<div class="custom-modal-body"></div>');
    var $actionBtn = jQuery('<button class="custom-modal-btn">Acceptar</button>');

    $body
        .append('<span class="custom-modal-icon">' + iconHtml + '</span>')
        .append('<h2 class="custom-modal-title">' + title + '</h2>')
        .append('<p class="custom-modal-text">' + message + '</p>')
        .append($actionBtn);

    $content.append($closeBtn).append($body);
    $backdrop.append($content);
    jQuery('body').append($backdrop);

    // Activar animació d'entrada
    setTimeout(function () { $backdrop.addClass('active'); }, 10);

    // Funció de tancament amb animació
    function closeModal() {
        $backdrop.removeClass('active');
        setTimeout(function () { $backdrop.remove(); }, 300);
    }

    // Tancar en clicar el botó X
    $closeBtn.on('click', function (e) {
        e.stopPropagation();
        closeModal();
    });

    // Tancar en clicar el botó Acceptar
    $actionBtn.on('click', function (e) {
        e.stopPropagation();
        closeModal();
    });

    // Tancar en clicar el fons transparent (backdrop)
    $backdrop.on('click', function (e) {
        if (jQuery(e.target).is('.custom-modal-backdrop')) {
            closeModal();
        }
    });
}