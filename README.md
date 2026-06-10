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
