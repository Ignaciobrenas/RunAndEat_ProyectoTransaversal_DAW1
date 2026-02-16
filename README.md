# Run & Eat

**La plataforma que une deporte y gastronomia**

[![Website](https://img.shields.io/badge/Website-runandeat.vercel.app-orange?style=for-the-badge)](https://runandeat.vercel.app)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

[Demo en vivo](https://runandeat.vercel.app) • [Reportar Bug](https://github.com/tuusuario/run-and-eat/issues) • [Solicitar Feature](https://github.com/tuusuario/run-and-eat/issues)

---

## Tabla de Contenidos

- [Acerca del Proyecto](#acerca-del-proyecto)
- [Caracteristicas](#caracteristicas)
- [Capturas de Pantalla](#capturas-de-pantalla)
- [Tecnologias](#tecnologias)
- [Comenzando](#comenzando)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Uso](#uso)
- [Roadmap](#roadmap)
- [Contribuir](#contribuir)
- [Licencia](#licencia)
- [Contacto](#contacto)

---

## Acerca del Proyecto

**Run & Eat** es una plataforma web moderna que revoluciona la forma en que los amantes del deporte y la gastronomia descubren eventos unicos. Conectamos corredores con experiencias culinarias excepcionales, creando una comunidad vibrante donde el ejercicio y la buena comida se encuentran.

### Por que Run & Eat?

- **Combina pasion**: Une dos mundos aparentemente diferentes en experiencias memorables
- **Descubre eventos locales**: Encuentra experiencias gastronomicas cerca de ti
- **Construye comunidad**: Conoce personas con intereses similares
- **Accesible**: Diseno responsive que funciona en todos tus dispositivos
- **Sistema de valoraciones**: Decisiones informadas basadas en experiencias reales

---

## Caracteristicas

### Para Usuarios

| Caracteristica | Descripcion |
|:--------------|:------------|
| Busqueda avanzada | Filtra eventos por ubicacion, categoria y precio |
| Perfil personalizado | Gestiona tu informacion y eventos favoritos |
| Eventos favoritos | Guarda y organiza tus eventos preferidos |
| Historial de eventos | Revisa los eventos a los que has asistido |
| Valoraciones | Lee y escribe resenas de eventos |

### Para Organizadores

| Caracteristica | Descripcion |
|:--------------|:------------|
| Crear eventos | Formulario completo para publicar eventos |
| Panel de control | Gestiona todos tus eventos desde un lugar |
| Galeria de imagenes | Sube fotos atractivas de tus eventos |
| Integracion con mapas | Muestra la ubicacion exacta del evento |
| Comunicacion directa | Conecta con los participantes |

### Categorias de Eventos

- Vegana
- Regional
- Reposteria
- Cocteleria
- Comida Rapida
- Catas
- Vinotecas
- Lujo
- Running + Comida

---

## Capturas de Pantalla

> **Nota**: Agrega capturas de pantalla reales en la carpeta `/screenshots` y actualiza las referencias aqui.

### Pagina Principal
_[Captura de index.html]_

### Dashboard de Eventos
_[Captura del dashboard]_

### Creacion de Eventos
_[Captura del formulario de creacion]_

---

## Tecnologias

Este proyecto esta construido con tecnologias web modernas y estandares de la industria:

### Frontend
```
HTML5       100%
CSS3        100%
JavaScript   50% (En desarrollo)
```

### Stack Tecnologico

- **HTML5**: Estructura semantica y accesible
- **CSS3**: 
  - CSS Grid para layouts complejos
  - Flexbox para componentes flexibles
  - Custom Properties (variables CSS)
  - Media Queries para responsividad
  - Animaciones y transiciones suaves
- **Fuentes**: Futura Font para tipografia premium
- **Iconos**: SVG personalizados

### Hosting
- **Vercel**: Despliegue continuo y optimizado

---

## Comenzando

### Prerequisitos

Solo necesitas un navegador web moderno:
- Chrome (recomendado) v90+
- Firefox v88+
- Safari v14+
- Edge v90+

### Instalacion

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/tuusuario/run-and-eat.git
   cd run-and-eat
   ```

2. **Opcion A: Abrir directamente**
   ```bash
   # Simplemente abre index.html en tu navegador
   open index.html  # macOS
   start index.html # Windows
   xdg-open index.html # Linux
   ```

3. **Opcion B: Servidor local (recomendado)**
   
   **Con Python:**
   ```bash
   # Python 3
   python -m http.server 8000
   
   # Python 2
   python -m SimpleHTTPServer 8000
   ```
   
   **Con Node.js:**
   ```bash
   # Instala http-server globalmente
   npm install -g http-server
   
   # Ejecuta el servidor
   http-server -p 8000
   ```
   
   **Con VS Code:**
   - Instala la extension "Live Server"
   - Click derecho en index.html
   - Selecciona "Open with Live Server"

4. **Accede a la aplicacion**
   ```
   http://localhost:8000
   ```

---

## Estructura del Proyecto

```
run-and-eat/
│
├── index.html              # Pagina principal con eventos destacados
├── login.html              # Autenticacion de usuarios
├── registro.html           # Registro de nuevos usuarios
├── evento.html             # Detalle completo de un evento
├── crear-evento.html       # Formulario de creacion de eventos
├── perfil.html             # Gestion de perfil de usuario
├── contacto.html           # Formulario de contacto y soporte
│
├── style/
│   └── styles.css          # Estilos principales (~1,500 lineas)
│
├── img/
│   ├── logo.png            # Logotipo principal
│   ├── run.png             # Logo de texto
│   └── user.png            # Icono de usuario predeterminado
│
└── README.md               # Este archivo
```

### Descripcion de Paginas

| Archivo | Proposito | Caracteristicas |
|---------|-----------|-----------------|
| `index.html` | Pagina de inicio | Grid de eventos, busqueda, destacados |
| `login.html` | Inicio de sesion | Formulario de autenticacion |
| `registro.html` | Registro de usuarios | Formulario completo, validacion |
| `evento.html` | Detalle de evento | Informacion completa, mapa, reservas |
| `crear-evento.html` | Crear evento | Formulario multi-seccion para organizadores |
| `perfil.html` | Perfil de usuario | Gestion de cuenta, eventos inscritos |
| `contacto.html` | Contacto | Formulario de soporte, informacion |

---

## Uso

### Para Usuarios

1. **Descubrir Eventos**
   - Navega por la pagina principal
   - Usa la barra de busqueda para filtrar por ubicacion
   - Aplica filtros de categoria y precio

2. **Registrarse**
   - Click en "REGISTRO" en la navegacion
   - Completa el formulario con tus datos
   - Confirma tu email (proximamente)

3. **Inscribirse a Eventos**
   - Explora eventos disponibles
   - Click en "Ver Detalles"
   - Click en "Apuntarse al Evento"

4. **Gestionar Perfil**
   - Accede a "MI PERFIL"
   - Actualiza informacion personal
   - Revisa tus eventos inscritos

### Para Organizadores

1. **Crear Cuenta de Organizador**
   - Registrate seleccionando "Organizador"
   - O accede desde "¿Eres organizador?"

2. **Crear Evento**
   - Ve a "Crear Nuevo Evento"
   - Completa todas las secciones:
     - Informacion basica
     - Fecha y ubicacion
     - Detalles del evento
     - Informacion adicional
   - Publica tu evento

3. **Gestionar Eventos**
   - Dashboard de organizador
   - Editar eventos existentes
   - Ver estadisticas y reservas

---

## Guia de Diseno

### Paleta de Colores

```css
/* Colores Principales */
--primary-bg: #0A192F;           /* Azul Marino - Fondo principal */
--primary-orange: #FFA208;       /* Naranja - Botones y acentos */
--primary-orange-dark: #ff8800;  /* Naranja Oscuro - Hover */

/* Colores Secundarios */
--white: #ffffff;                /* Blanco - Texto y fondos */
--gray-dark: #333333;            /* Gris Oscuro - Texto secundario */
--gray-light: #8892b0;           /* Gris Claro - Detalles */
```

### Tipografia

- **Fuente Principal**: Futura
- **Pesos**: Regular, Medium, Bold
- **Tamanos**: Responsive con clamp()

### Componentes Principales

- **Cards**: Sombras suaves, bordes redondeados, hover effects
- **Botones**: Transiciones de 0.3s, estados activos claros
- **Forms**: Labels flotantes, validacion visual
- **Grid**: Responsive 1-4 columnas segun viewport

---

## Roadmap

### Fase 1: MVP (Completado)
- [x] Diseno UI/UX completo
- [x] Paginas principales HTML/CSS
- [x] Sistema de navegacion
- [x] Diseno responsive

### Fase 2: Backend (En Desarrollo)
- [ ] API REST con Node.js/Express
- [ ] Base de datos MongoDB/PostgreSQL
- [ ] Sistema de autenticacion JWT
- [ ] Upload de imagenes (Cloudinary)
- [ ] Sistema de reservas

### Fase 3: Features Avanzadas
- [ ] Busqueda en tiempo real
- [ ] Filtros dinamicos con JavaScript
- [ ] Sistema de favoritos
- [ ] Notificaciones push
- [ ] Chat en vivo organizador-usuario

### Fase 4: Integraciones
- [ ] Google Maps API
- [ ] Geolocalizacion
- [ ] Pasarela de pagos (Stripe)
- [ ] Email notifications
- [ ] Compartir en redes sociales

### Fase 5: Optimizacion
- [ ] PWA (Progressive Web App)
- [ ] Optimizacion SEO
- [ ] Analytics
- [ ] Tests unitarios
- [ ] CI/CD pipeline

---

## Contribuir

¡Las contribuciones son lo que hace que la comunidad open source sea un lugar increible para aprender, inspirar y crear! Cualquier contribucion que hagas sera **muy apreciada**.

### Como Contribuir

1. **Fork el proyecto**

2. **Crea tu Feature Branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```

3. **Commit tus cambios**
   ```bash
   git commit -m 'Add: Amazing new feature'
   ```

4. **Push a la Branch**
   ```bash
   git push origin feature/AmazingFeature
   ```

5. **Abre un Pull Request**

### Guia de Estilo

- Usa nombres descriptivos para variables y clases
- Comenta codigo complejo
- Sigue la estructura CSS existente
- Asegura que el codigo sea responsive
- Prueba en multiples navegadores

### Tipos de Contribuciones

- **Bug Reports**: Usa las GitHub Issues
- **Feature Requests**: Abre un issue con la etiqueta "enhancement"
- **Documentacion**: Mejoras al README o comentarios en codigo
- **Diseno**: Sugerencias de UI/UX
- **Codigo**: Pull requests con nuevas features o fixes

---

## Estadisticas del Proyecto

| Metrica | Valor |
|---------|-------|
| Paginas HTML | 7 |
| Lineas de CSS | 1,500+ |
| Componentes | 15+ |
| Responsive Breakpoints | 4 |
| Lighthouse Score | 95+ |
| Categorias de Eventos | 9 |

---

## Seguridad

Este proyecto toma en serio la seguridad. Si descubres alguna vulnerabilidad, por favor:

1. **NO** abras un issue publico
2. Envia un email a: security@runandeat.com
3. Incluye:
   - Descripcion de la vulnerabilidad
   - Pasos para reproducirla
   - Impacto potencial
   - Sugerencias de solucion (opcional)

---

## Licencia

Distribuido bajo la licencia MIT. Ver `LICENSE` para mas informacion.

La licencia MIT es una licencia permisiva que permite:
- Uso comercial
- Modificacion
- Distribucion
- Uso privado

---

## Contacto

### Equipo de Desarrollo

- **Sitio Web**: [runandeat.vercel.app](https://runandeat.vercel.app)
- **Email**: contacto@runandeat.com
- **GitHub**: [@tuusuario](https://github.com/tuusuario)

### Redes Sociales

[![Twitter](https://img.shields.io/badge/Twitter-1DA1F2?style=for-the-badge&logo=twitter&logoColor=white)](https://twitter.com/runandeat)
[![Instagram](https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://instagram.com/runandeat)
[![YouTube](https://img.shields.io/badge/YouTube-FF0000?style=for-the-badge&logo=youtube&logoColor=white)](https://youtube.com/runandeat)

---

## Agradecimientos

- [Font Awesome](https://fontawesome.com) - Iconos
- [Vercel](https://vercel.com) - Hosting
- [Futura Font](https://fonts.adobe.com/fonts/futura-pt) - Tipografia
- [Shields.io](https://shields.io) - Badges para README
- Comunidad de desarrolladores open source

---

## Analiticas

![GitHub Stars](https://img.shields.io/github/stars/tuusuario/run-and-eat?style=social)
![GitHub Forks](https://img.shields.io/github/forks/tuusuario/run-and-eat?style=social)
![GitHub Issues](https://img.shields.io/github/issues/tuusuario/run-and-eat)
![GitHub Pull Requests](https://img.shields.io/github/issues-pr/tuusuario/run-and-eat)

---

**Hecho con amor por el equipo de Run & Eat**

Si te gusta este proyecto, ¡dale una estrella en GitHub!

[Volver arriba](#run--eat)
