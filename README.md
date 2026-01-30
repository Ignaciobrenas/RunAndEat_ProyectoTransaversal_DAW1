# 🏃 Run & Eat - Plataforma de Eventos Gastronómicos
runandeat.vercel.app

Una plataforma moderna y responsiva para descubrir y crear eventos gastronómicos únicos. Perfecta para corredores y amantes de la buena comida que buscan experiencias culinarias cercanas a su ubicación.

---

## 📋 Descripción del Proyecto

**Run & Eat** es una aplicación web completa que conecta a organizadores de eventos gastronómicos con usuarios interesados en descubrir nuevas experiencias culinarias. La plataforma ofrece un sistema integral de búsqueda, filtrado, registro y gestión de eventos.

### Características Principales

- 🔍 **Búsqueda de Eventos** - Busca eventos gastronómicos por ubicación
- 🎯 **Filtros Avanzados** - Filtra por categoría, precio y tipo de cocina
- 📝 **Creación de Eventos** - Los organizadores pueden crear y publicar nuevos eventos
- 👤 **Perfil de Usuario** - Sistema completo de gestión de perfil y eventos favoritos
- 🔐 **Autenticación** - Registro e inicio de sesión de usuarios
- ⭐ **Valoraciones** - Sistema de calificación de eventos
- 📱 **Diseño Responsivo** - Compatible con dispositivos móviles y de escritorio

---

## 🗂️ Estructura del Proyecto

```
run-and-eat/
│
├── index.html              # Página de inicio
├── login.html              # Página de inicio de sesión
├── registrer.html          # Página de registro
├── eventos.html            # Página de eventos (vacía)
├── buscar_eventos.html     # Página de búsqueda y filtrado de eventos
├── crear.html              # Página de creación de eventos
├── dashboard.html          # Panel de control principal
├── contacto.html           # Página de contacto
├── user.html               # Perfil de usuario
│
├── style/
│   └── styles.css          # Estilos principales (44KB)
│
├── img/                    # Carpeta de imágenes
│   ├── logo.png            # Logo principal
│   ├── run.png             # Logo de texto
│   └── user.png            # Icono de usuario
│
└── README.md               # Este archivo
```

---

## 🔧 Tecnologías Utilizadas

- **HTML5** - Estructura semántica
- **CSS3** - Diseño y estilos avanzados
  - CSS Grid
  - Flexbox
  - Media Queries
  - Transiciones y animaciones
- **JavaScript** (potencial) - Para funcionalidad interactiva
- **Futura Font** - Tipografía personalizada

---

## 🎨 Paleta de Colores

| Color | Código | Uso |
|-------|--------|-----|
| **Azul Marino** | `#0A192F` | Fondo principal |
| **Naranja** | `#FFA208` | Botones y acentos |
| **Naranja Oscuro** | `#ff8800` | Estados hover |
| **Blanco** | `#ffffff` | Texto y fondos secundarios |
| **Gris** | `#333333` | Texto secundario |

---

## 📄 Páginas y Funcionalidades

### 1. **Página de Inicio** (`index.html`)
- Presentación de la plataforma
- Barra de búsqueda principal
- Opción para organizadores
- Tarjetas de eventos destacados

### 2. **Registro** (`registrer.html`)
- Formulario completo de registro
- Campos: nombre, fecha de nacimiento, dirección, email, contraseña
- Aceptación de términos y condiciones
- Validación de formularios

### 3. **Inicio de Sesión** (`login.html`)
- Formulario de login
- Opción "Olvidé mi contraseña"
- Enlaces a registro y eventos

### 4. **Búsqueda de Eventos** (`buscar_eventos.html`)
- Barra de búsqueda por ubicación
- Filtros por categoría:
  - Vegana
  - Regional
  - Repostería
  - Coctelería
  - Comida rápida
  - Catas
  - Vinotecas
  - Lujo
- Filtro de precio con slider
- Opciones de ordenamiento
- Paginación

### 5. **Dashboard** (`dashboard.html`)
- Panel principal con eventos recomendados
- Sidebar con filtros
- Grid de 4 columnas con tarjetas de eventos
- Sistema de paginación
- Filtros secundarios adicionales

### 6. **Creación de Eventos** (`crear.html`)
- Formulario para crear nuevos eventos
- Carga de imagen del evento
- Campos: nombre, organizador, fecha, descripción
- Checkbox de términos y condiciones

### 7. **Perfil de Usuario** (`user.html`)
- Sección de información personal
- Cambio de foto de perfil
- Gestión de eventos a los que se ha apuntado
- Sistema de cambio de contraseña
- Seguridad de dos factores
- Navegación por pestañas

### 8. **Contacto** (`contacto.html`)
- Formulario de contacto
- Información de la empresa
- Enlaces a redes sociales (Twitter, YouTube, Instagram)

---

## 🚀 Cómo Comenzar

### Requisitos Previos
- Navegador web moderno (Chrome, Firefox, Safari, Edge)
- No requiere instalación de dependencias

### Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/tuusuario/run-and-eat.git
   cd run-and-eat
   ```

2. **Abrir en el navegador**
   - Opción A: Doble clic en `index.html`
   - Opción B: Usar un servidor local (recomendado)
   ```bash
   # Con Python 3
   python -m http.server 8000
   
   # Con Python 2
   python -m SimpleHTTPServer 8000
   
   # Con Node.js (http-server)
   npx http-server
   ```

3. **Acceder a la aplicación**
   ```
   http://localhost:8000
   ```

---

## 📱 Características de Diseño

### Responsividad
- Diseño adaptable para móviles, tablets y escritorio
- Uso de CSS Grid y Flexbox
- Media queries para diferentes resoluciones

### Experiencia de Usuario
- Animaciones suaves en botones y transiciones
- Efectos hover intuitivos
- Paleta de colores coherente
- Tipografía legible

### Accesibilidad
- Etiquetas semánticas HTML
- Atributos aria-label en enlaces
- Formularios con labels asociados
- Contraste de colores adecuado

---

## 🔐 Seguridad y Autenticación

El proyecto está estructurado para implementar:
- Sistema de autenticación de usuarios
- Encriptación de contraseñas (backend)
- Validación de formularios (frontend y backend)
- Verificación de dos factores (preparado en UI)

---

## 📊 Sistema de Filtros

### Filtros de Categoría
```
- Vegana
- Regional
- Repostería
- Coctelería
- Comida rápida
- Catas
- Vinotecas
- Lujo
```

### Filtros de Precio
- Rango deslizable de 0 a 100€
- Visualización en tiempo real

### Ordenamiento
- Mejor Valoradas
- Precio más alto
- Precio más bajo
- Novedades
- Premium
- Oferta

---

## 🎯 Próximos Pasos / Mejoras Futuras

### Backend
- [ ] Implementar Node.js/Express o Django
- [ ] Base de datos (MongoDB/PostgreSQL)
- [ ] API REST completa
- [ ] Sistema de autenticación JWT

### Frontend
- [ ] Integrar JavaScript para funcionalidad dinámica
- [ ] Sistema de favoritos
- [ ] Carrito de reservas
- [ ] Chat en tiempo real
- [ ] Notificaciones push

### Funcionalidades Adicionales
- [ ] Integración de mapas (Google Maps)
- [ ] Geolocalización
- [ ] Sistema de pagos (Stripe)
- [ ] Reseñas y comentarios
- [ ] Fotos galerías de eventos

---

## 📞 Contacto y Soporte

Para preguntas, sugerencias o reportar bugs, utiliza:
- **Email**: contacto@runandeat.com
- **Página de contacto**: `contacto.html`
- **Redes sociales**: Twitter, YouTube, Instagram

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver `LICENSE` para más detalles.

---

## 👥 Contribuidores

- **Equipo de Desarrollo**: [Tu nombre/equipo]
- Creado con ❤️ para los amantes del deporte y la buena comida

---

## 📈 Estadísticas del Proyecto

| Métrica | Valor |
|---------|-------|
| Páginas HTML | 9 |
| Líneas CSS | 1,500+ |
| Fuentes personalizadas | 1 |
| Paleta de colores | 5 |
| Páginas responsivas | 100% |

---

## 🔗 Enlaces Rápidos

- [Página de Inicio](index.html)
- [Dashboard](dashboard.html)
- [Buscar Eventos](buscar_eventos.html)
- [Crear Evento](crear.html)
- [Mi Perfil](user.html)
- [Contacto](contacto.html)

---

**¡Bienvenido a Run & Eat! 🏃‍♂️🍽️**

*Corre. Come. Repite.*
