# Inspección de Frontend y Guía de Mejoras - Proyecto Suraki HelpDesk

Este documento tiene como objetivo organizar y detallar los archivos clave del frontend del sistema Suraki HelpDesk. Aquí podrás documentar, planificar y ejecutar las mejoras de diseño e interfaz de usuario (UI/UX) de manera ordenada.

## 🛠️ Tecnologías Principales (Frontend)
- **Framework CSS:** Tailwind CSS.
- **Reactividad:** Laravel Livewire 3 y Blade (Plantillas nativas de Laravel con recargas dinámicas).
- **Compilador de Assets:** Vite.

---

## 📂 Directorio de Archivos Clave del Frontend

A continuación se detalla la ubicación exacta de los archivos visuales en los que estarás trabajando para mejorar la estética del proyecto:

### 1. Vistas Generales y Plantillas (Layouts)
Estos archivos controlan la estructura global que envuelve a toda la aplicación (como los fondos, menú principal, etc).
- `resources/views/layouts/app.blade.php`: (Si está publicado) La plantilla maestra. Aquí puedes cambiar el fondo de toda la aplicación y enlazar fuentes como Google Fonts.
- `resources/views/dashboard.blade.php`: El panel principal o "Home" de bienvenida.
- `resources/views/livewire/layout/navigation.blade.php`: La barra de navegación superior (Header). Aquí puedes mejorar el logo, menú de usuario y el diseño responsivo.

### 2. Componentes de Tickets (Pantallas Principales)
Aquí se concentra la mayor parte de la interfaz donde interactúa el usuario y los administradores.
- `resources/views/livewire/tickets/ticket-list.blade.php`: La tabla dinámica de tickets. **Área de mejora:** Puedes hacer la tabla más moderna, cambiar el estilo de las tarjetas en móviles, y mejorar los botones de filtros usando Tailwind.
- `resources/views/livewire/tickets/ticket-form.blade.php`: El formulario de creación de requerimientos. **Área de mejora:** Estilizar los inputs, selects y botones de envío para que se vean amigables.
- `resources/views/livewire/tickets/ticket-detail.blade.php`: El panel de administración de cada ticket. **Área de mejora:** Mejorar la visualización del historial, estados y darle un aspecto de chat o línea de tiempo (timeline).

### 3. Notificaciones e Interfaz Dinámica
- `resources/views/livewire/layout/notification-bell.blade.php` (o similar, definido en `app/Livewire/Layout/NotificationBell.php`): El icono de la campana. **Área de mejora:** Agregar efectos CSS (como animaciones de pulso) cuando detecte un cambio.

### 4. Inicio de Sesión (Auth)
- `resources/views/livewire/pages/auth/login.blade.php`: La pantalla principal de login (por `username`). **Área de mejora:** Cambiar de un diseño básico a algo muy premium (sombras, degradados, imagen de fondo).

### 5. Estilos Base y Configuración
- `tailwind.config.js`: **Archivo Clave**. Aquí debes declarar los colores corporativos de "Suraki" o la paleta personalizada (para poder usar clases como `bg-suraki-primary`).
- `resources/css/app.css`: Archivo CSS principal. Útil si necesitas meter CSS puro, animaciones complejas personalizadas (`@keyframes`) o importar fuentes.

---

## 📋 Plan de Acción y Seguimiento de Mejoras (Checklist para Alberto)

Utiliza este espacio para marcar tu progreso:

- [ ] **Configurar Paleta de Colores:** Identificar los colores corporativos y agregarlos a `tailwind.config.js`.
- [ ] **Tipografía Moderna:** Importar una fuente premium (ej. Inter, Outfit o Roboto) en `resources/css/app.css`.
- [ ] **Rediseño del Login:** Aplicar un layout moderno, con esquinas redondeadas y efectos "glassmorphism" (vidrio esmerilado) si aplica.
- [ ] **UI de Tabla de Tickets:** Eliminar bordes pesados, agregar "hover effects" sutiles a cada fila, y separar visualmente las columnas.
- [ ] **Badges de Estado:** Diseñar componentes bonitos para los estados (Ej: píldoras redondeadas de color Rojo suave para Crítico, Verde para Resuelto).
- [ ] **Modo Responsivo:** Asegurarse de que el formulario y la tabla se adapten perfectamente a las pantallas de los celulares de los usuarios en sucursal.

---
*Documento creado y mantenido por: Alberto para las mejoras UI/UX del proyecto.*
