// Manejo del desplegable de filtros
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const filterBtn = document.querySelector('.filter-icon');
    const searchContainer = document.querySelector('.search-container');
    
    // Crear el dropdown de filtros si estamos en la página de eventos
    if (filterBtn && searchContainer) {
        createFilterDropdown();
        
        filterBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.querySelector('.filter-dropdown');
            dropdown.classList.toggle('active');
        });
        
        // Cerrar dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.filter-dropdown');
            if (dropdown && !searchContainer.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }
    
    // Inicializar sliders
    initializeRangeSliders();
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
        precioSlider.addEventListener('input', function() {
            precioValue.textContent = this.value + '€';
        });
    }
    
    // Slider de distancia
    const distanciaSlider = document.getElementById('filter-distancia');
    const distanciaValue = document.getElementById('distancia-value');
    
    if (distanciaSlider && distanciaValue) {
        distanciaSlider.addEventListener('input', function() {
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
    alert('Filtros aplicados correctamente. En la versión final con PHP, esto filtrará los eventos.');
    
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
        
        reader.onload = function(e) {
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
