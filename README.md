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

Existen **tres roles** definidos en la base de datos (`enum`):

1.  **`admin` (Administrador de Sistemas):**
    *   Tiene visión global y control total del sistema.
    *   Puede ver, editar y gestionar todos los tickets, requerimientos e inventario.
    *   Tiene acceso exclusivo a configuración, reportes y gestión de usuarios.
2.  **`outsourcing` (Personal Técnico Externo):**
    *   Actúa operativamente como un administrador en las mesas de ayuda.
    *   Tiene visión global de los tickets y requerimientos de soporte.
    *   Gestiona su propio panel de horarios por turnos y check-in en el sistema.
3.  **`usuario` (Usuario Final):**
    *   Visión y control estrictamente limitados a sus propios requerimientos y tickets.
    *   Solo puede visualizar el progreso de lo que él mismo ha creado (`creator_id`).
    *   Interfaz limpia sin opciones avanzadas, menús de administración ni filtros complejos.

---

## 📦 Módulos del Sistema (Auditoría Actualizada)

A medida que el proyecto ha escalado, se han integrado diversos módulos esenciales:

1. **Gestión de Tickets (Soporte Técnico):**
   * Control de incidentes por sucursal, área y equipo afectado.
   * Prioridades (Baja, Media, Alta, Crítica) y estados dinámicos (Abierto, En Proceso, Pendiente, Resuelto, Cerrado).
2. **Requerimientos (Requests):**
   * Control de solicitudes específicas, asignación de responsables (`assigned_to`), urgencia y fecha de entrega.
   * Sistema de subida de comprobantes (`proof`), guías de remisión (`delivery_note`) y sección de notas internas.
   * Historial de comentarios (`RequestComment`) en tiempo real.
3. **Control de Inventario (Inventory):**
   * CRUD completo para la gestión del parque informático (`Device`) de cada sucursal y departamento.
4. **Horarios y Turnos (Schedules):**
   * Control de horarios de personal interno (`UserSchedule`).
   * Gestión de turnos y personal externo (Outsourcing) mediante `WorkShift`.
5. **Auditoría y Logs:**
   * Tablas `activity_logs` y `route_logs` para llevar trazabilidad de las acciones y accesos de los usuarios en el sistema.

---

## 🔔 Sistema de Notificaciones y Tiempo Real

El proyecto está diseñado para funcionar de manera dinámica ("magia") sin recargar la página, utilizando el sistema de **Polling de Livewire** (`wire:poll`):

*   **Campanita (In-App):** Ubicada en la barra de navegación. Notifica cambios de estado y asignaciones en tiempo real (Sondeo cada 5s).
*   **Notificaciones Críticas (Observer):** Si un ticket se levanta con prioridad "Crítica", el `TicketObserver` dispara una alerta por Correo Electrónico (procesada por las Colas de Laravel) a todos los Administradores, además de la notificación interna.
*   **Dashboard en Vivo:** Las tablas reflejan los cambios que hagan otros usuarios instantáneamente.

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

## 🚀 Hoja de Ruta y Posibles Mejoras (Expert Roadmap)

Tras una auditoría arquitectónica profunda, se plantean las siguientes optimizaciones de grado *Senior (15+ años exp)* para futuras iteraciones:

*   **Desacoplamiento (Service Classes):** Extraer la lógica de negocio pesada de los componentes de Livewire (ej. cálculos de inventario o asignaciones de requerimientos) hacia clases de Servicio (`App\Services`). Esto evitará "Fat Controllers" y facilitará las pruebas.
*   **Optimización de Queries (N+1) y Caché:** Implementar *Eager Loading* de manera estricta en todas las vistas de tablas (Livewire) y aplicar caché en consultas frecuentes que mutan poco (Ej. listado de Sucursales y Departamentos usando `Cache::remember`).
*   **Testing Automatizado:** Configurar e implementar `Pest PHP` para testear el backend y las interacciones de los componentes clave de Livewire para evitar regresiones.
*   **UI/UX Avanzado:** Añadir "Skeleton Loaders" (pantallas de carga falsa) para las transiciones de Livewire y notificaciones Toast no intrusivas en los CRUDs.
*   **Seguridad:** Implementar Rate Limiting más agresivo en las rutas de login y estudiar la viabilidad de 2FA para cuentas administrativas.

---

## 📜 Historial de Cambios (Changelog)

### Fase 1: Inicialización y Arquitectura Base
*   Levantar Laravel 11, Livewire, BDD y autenticación básica de Breeze. (Archivos clave: `composer.json`, `.env`, configuración inicial).

### Fase 2: Modelado de Datos de Soporte
*   Creación de migraciones para `Sucursales`, `Tickets` y personalización de la tabla `Users` con campos como `rol` y `username`.

### Fase 3: Lógica de Negocio y Notificaciones Backend
*   Implementación del patrón Observer (`TicketObserver.php`) y envío de correos asíncronos en cola para tickets críticos. Seeders base.

### Fase 4: Refactorización Login y Tiempo Real
*   Login por `username`.
*   Componente `NotificationBell.php` (Campanita) y Polling Livewire para UI dinámica.
*   CRUD y tablas dinámicas de Tickets.

### Fase 5: Vista de Detalle y Políticas de Seguridad
*   Middleware `CheckRole.php` y Policies (`TicketPolicy.php`) para asegurar que usuarios limitados no accedan a información de administradores.
*   Gestión individual del estado de los tickets.

### Fase 6: Expansión Funcional (Auditoría y Módulos Extra)
*   **Requerimientos:** Creación del módulo Requests con asignaciones, validaciones (comprobantes, guía de remisión) y sistema de comentarios en hilo (`RequestComment`).
*   **Inventario:** Nuevo módulo (`Device`) integrado a Livewire para controlar el hardware por sucursal.
*   **Horarios:** Integración del control de turnos y personal interno (`UserSchedule`) y outsourcing (`WorkShift`).
*   **Logs:** Implementación de tablas `activity_logs` y `route_logs` para control y trazabilidad administrativa.
*   **Configuración:** Pantalla base para configuraciones dinámicas (`Settings`).
