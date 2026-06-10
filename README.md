# Suraki HelpDesk 🚀

Sistema de Soporte TI Monolítico desarrollado exclusivamente para el departamento de sistemas de la empresa Suraki. El enfoque de este software es **alta eficiencia, código limpio, seguridad web y simplicidad operativa**, evitando dependencias pesadas y manteniendo un flujo de trabajo rápido.

## 🛠️ Stack Tecnológico

*   **Backend & Framework:** Laravel 11 (PHP 8.3+)
*   **Frontend & Reactividad:** Laravel Livewire 3 + Blade (Sin Vue/React, recargas dinámicas mediante componentes de servidor).
*   **Estilos:** Tailwind CSS.
*   **Base de Datos:** MySQL.
*   **Procesamiento en Segundo Plano:** Base de datos nativa de Laravel (`QUEUE_CONNECTION=database`) para el envío de correos y procesos pesados sin bloquear la interfaz.

---

## 👥 Sistema de Roles y Autenticación

El sistema utiliza un inicio de sesión personalizado a través de un **Username** (ej: `pedro_caja1`) en lugar de correo electrónico, para facilitar el acceso rápido del personal de sucursales. Sin embargo, los correos se almacenan para notificaciones.

Existen exclusivamente **dos roles** definidos en la base de datos (`enum`):

1.  **`admin` (Administrador de Sistemas):**
    *   Tiene visión global.
    *   Puede ver todos los tickets de todas las sucursales.
    *   Tiene acceso a filtros avanzados (Estado, Prioridad).
    *   Puede asignar tickets y cambiar sus estados.
2.  **`usuario` (Usuario Final):**
    *   Visión limitada a sus propios requerimientos.
    *   Solo puede ver los tickets que él mismo ha creado (`creator_id`).
    *   Interfaz simplificada sin filtros complejos.

---

## 🎫 Gestión de Tickets y Estados

Cada ticket recopila información crucial sin necesidad de un inventario previo complejo:
*   **Sucursal:** (Ej: Andinka, Kikana, Nabilka).
*   **Área/Departamento:** (Ej: Caja 1, Gerencia).
*   **Equipo Afectado:** (Ej: Impresora 02, PC Principal).
*   **Prioridad:** Baja, Media, Alta, Crítica.
*   **Estados del Ticket:** Abierto, Asignado, En Proceso, Pendiente, Resuelto, Cerrado.

---

## 🔔 Sistema de Notificaciones y Tiempo Real

El proyecto está diseñado para funcionar de manera dinámica ("magia") sin recargar la página, utilizando el sistema de **Polling de Livewire** (`wire:poll`):

*   **Campanita (In-App):** Ubicada en la barra de navegación. Notifica cambios de estado y asignaciones en tiempo real (Sondeo cada 5s).
*   **Notificaciones Críticas (Observer):** Si un ticket se levanta con prioridad "Crítica", el `TicketObserver` dispara una alerta por Correo Electrónico (procesada por las Colas de Laravel) a todos los Administradores, además de la notificación interna.
*   **Dashboard en Vivo:** Las tablas de tickets reflejan los cambios que hagan otros usuarios instantáneamente.

---

## 💻 Guía de Instalación para Desarrolladores

Si otro desarrollador o Agente de IA necesita levantar el entorno, estos son los pasos a seguir:

1.  **Clonar el repositorio** y acceder a la carpeta:
    ```bash
    cd suraki-helpdesk
    ```
2.  **Instalar dependencias de PHP y Node:**
    ```bash
    composer install
    npm install
    ```
3.  **Configurar Variables de Entorno:**
    Duplicar `.env.example` a `.env` y asegurar las siguientes variables:
    ```env
    DB_CONNECTION=mysql
    DB_DATABASE=suraki_helpdesk
    QUEUE_CONNECTION=database
    ```
4.  **Generar Key y Migrar:**
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```
    *(El seeder creará sucursales base y 2 usuarios de prueba: `admin_sistemas` y `usuario_caja1`, ambos con clave `password`).*
5.  **Compilar Assets (Tailwind):**
    ```bash
    npm run build
    ```
6.  **Levantar el Trabajador de Colas:** (Obligatorio para que salgan los correos)
    ```bash
    php artisan queue:work
    ```

---

## 📂 Estructura Clave de Archivos (Para IA / Devs)
*   **Componentes Livewire:** `app/Livewire/Tickets/` y `app/Livewire/Layout/NotificationBell.php`.
*   **Vistas Livewire:** `resources/views/livewire/tickets/`.
*   **Modelos y Migraciones:** `app/Models/Ticket.php` (y User, Sucursal).
*   **Notificaciones y Observers:** `app/Notifications/` y `app/Observers/TicketObserver.php`.
*   **Autenticación:** Las vistas de Breeze (`resources/views/livewire/pages/auth/`) fueron modificadas para usar `username`. El archivo clave de lógica es `app/Livewire/Forms/LoginForm.php`.

---

## 📜 Historial de Cambios (Changelog)

Este proyecto se desarrolló en fases iterativas. A continuación, se detalla el progreso acumulado y los archivos que fueron modificados o creados en cada paso para mantener un estricto control de versiones.

### Fase 1: Inicialización y Arquitectura Base
*   **Objetivo:** Levantar el proyecto de Laravel 11 con Livewire, configurar la base de datos y la autenticación básica de Breeze.
*   **Archivos Afectados / Creados:**
    *   `composer.json` y `package.json` (Instalación de Laravel, Livewire y dependencias).
    *   `.env` (Configuración de conexión a base de datos MySQL).
    *   Instalación de Laravel Breeze (`php artisan breeze:install`).

### Fase 2: Modelado de Datos (Migraciones)
*   **Objetivo:** Crear la estructura de la base de datos para Sucursales, Tickets y adaptar Usuarios.
*   **Archivos Afectados / Creados:**
    *   `database/migrations/..._create_sucursals_table.php`: Creación de la tabla de sucursales.
    *   `database/migrations/..._create_tickets_table.php`: Estructura principal de los tickets (título, descripción, prioridad, estados, asignaciones).
    *   `database/migrations/..._add_fields_to_users_table.php`: Se añadieron los campos `rol`, `username` y `sucursal_id` a la tabla `users`.
    *   Modelos de Eloquent: `app/Models/Ticket.php`, `app/Models/Sucursal.php`, `app/Models/User.php`.

### Fase 3: Lógica de Negocio y Notificaciones Backend
*   **Objetivo:** Implementar los Seeders de prueba y el sistema asíncrono para enviar correos de emergencia (Tickets Críticos) usando colas y el patrón Observer.
*   **Archivos Afectados / Creados:**
    *   `database/seeders/SucursalSeeder.php`, `UserSeeder.php`, `TicketSeeder.php`, `DatabaseSeeder.php`.
    *   `app/Observers/TicketObserver.php`: Se conecta al evento "created" o "updated" del modelo Ticket para evaluar prioridades.
    *   `app/Notifications/TicketCriticoNotification.php`: Plantilla mailable del correo y configuración `ShouldQueue`.
    *   `bootstrap/providers.php`: Registro del Observer.

### Fase 4: Autenticación con Username, Tiempo Real y UI (Livewire)
*   **Objetivo:** Refactorizar el Login para usar `username`, construir el Dashboard reactivo con tablas filtrables, el formulario de tickets y la Campanita de notificaciones In-App usando Polling.
*   **Archivos Afectados / Creados:**
    *   `app/Livewire/Forms/LoginForm.php` y `resources/views/livewire/pages/auth/login.blade.php`: Cambio de lógica de validación de `email` a `username`.
    *   `app/Livewire/Layout/NotificationBell.php`: Componente de Livewire con `wire:poll.5s` para notificaciones In-App en tiempo real.
    *   `app/Livewire/Tickets/TicketList.php` (y `.blade.php`): Tabla dinámica para listar tickets, con filtros condicionales dependiendo del rol (Administrador vs Usuario) y `wire:poll.10s`.
    *   `app/Livewire/Tickets/TicketForm.php` (y `.blade.php`): Pantalla para creación de tickets.
    *   `resources/views/dashboard.blade.php` y `resources/views/livewire/layout/navigation.blade.php`: Inserción de los componentes visuales.
    *   `routes/web.php`: Nuevas rutas `/tickets/create` y `/tickets/{ticket}`.

### Fase 5: Vista de Detalle, Políticas de Seguridad y Middleware
*   **Objetivo:** Implementar la pantalla donde el administrador puede cambiar los estados y asignar tickets, y proteger la aplicación para que los usuarios no puedan violar los permisos (Ej. Error 403).
*   **Archivos Afectados / Creados:**
    *   `app/Livewire/Tickets/TicketDetail.php` (y `.blade.php`): Panel de gestión de un ticket individual.
    *   `app/Policies/TicketPolicy.php`: Archivo que dicta qué usuario puede ver o modificar qué ticket (Ej. usuarios normales solo ven los que ellos mismos crearon).
    *   `app/Http/Middleware/CheckRole.php`: Filtro de protección global de rutas que evalúa si un usuario posee o no privilegios de administrador.
    *   `bootstrap/app.php`: Registro del alias de middleware `role`.
    *   `README.md`: Documentación formal de la arquitectura y el proceso de instalación.
