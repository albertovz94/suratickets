# Suraki HelpDesk 🚀

Sistema de Soporte TI Monolítico desarrollado exclusivamente para el departamento de sistemas de la empresa Suraki. El enfoque de este software es **alta eficiencia, código limpio, seguridad web y simplicidad operativa**, evitando dependencias pesadas y manteniendo un flujo de trabajo rápido.

## 🛠️ Stack Tecnológico

*   **Backend & Framework:** Laravel 13.8 (PHP 8.3+)
*   **Frontend & Reactividad:** Laravel Livewire 3.6 + Blade (Sin Vue/React, recargas dinámicas mediante componentes de servidor).
*   **Estilos:** Tailwind CSS.
*   **Base de Datos:** MySQL.
*   **Procesamiento en Segundo Plano:** Base de datos nativa de Laravel (`QUEUE_CONNECTION=database`) para el envío de correos y procesos pesados sin bloquear la interfaz.
*   **Autenticación:** Laravel Breeze + Livewire/Volt (Login por `username`).

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

### Seguridad de Acceso

*   **Rate Limiting:** 5 intentos de login antes de bloqueo temporal. Auto-bloqueo permanente de cuenta tras 5 intentos fallidos consecutivos.
*   **CheckUserStatus Middleware:** Las cuentas `Bloqueada` o `Inactivo` son deslogueadas automáticamente.
*   **CheckRole Middleware:** Control de acceso granular por rol en rutas administrativas.
*   **Policies:** `TicketPolicy` y `EquipmentRequestPolicy` para control de propiedad de datos.

---

## 📦 Módulos del Sistema (Auditoría v2 — Junio 2026)

### 1. 🎫 Gestión de Tickets (Soporte Técnico)
*   Control de incidentes por sucursal, área y equipo afectado.
*   Prioridades (Baja, Media, Alta, Crítica) y estados dinámicos (Abierto, Asignado, En Proceso, Pendiente, Resuelto, Cerrado).
*   **Auto-asignación inteligente** (`CreateTicketAction`): Analiza palabras clave para calcular prioridad y asigna al admin con menor carga de trabajo que esté en turno activo.
*   **Chat de mensajes** en cada ticket con adjuntos.
*   Observer para notificaciones automáticas al crear/actualizar tickets.

### 2. 📋 Requerimientos (Requests)
*   Control de solicitudes de equipamiento con formulario wizard de 3 pasos.
*   Asignación de técnicos outsourcing (`assigned_to`), urgencia y flujo de estados (Pendiente → En Proceso → Entregado/Rechazado).
*   Sistema de subida de comprobantes (`proof`), guías de remisión (`delivery_note`).
*   Historial de comentarios (`RequestComment`) con política de 15 días para usuarios.

### 3. 💻 Control de Inventario (Inventory)
*   CRUD completo para la gestión del parque informático (`Device`) de cada sucursal y departamento.
*   Tipos: Laptop, Desktop, Servidor, Red, Impresora, Otro.
*   Ciclo de estados rápido: Activo ↔ En Reparación ↔ De Baja.
*   Buscador con autocomplete de usuarios asignados.
*   Importación masiva desde Excel (`EquiposImport`).
*   Estadísticas en tiempo real con caché.

### 4. 👥 Gestión de Usuarios
*   CRUD completo con avatar, roles, sucursal, departamento.
*   Envío automático de credenciales por email al crear usuario.
*   Toggle de estado Activo/Inactivo.
*   Soft Deletes para preservar integridad de datos históricos.

### 5. 🕐 Horarios y Turnos (Schedules)
*   Control de horarios fijos semanales (`UserSchedule`) para personal interno.
*   Gestión de turnos outsourcing (`WorkShift`) con Check-in/Check-out.
*   `ScheduleService` determina si un técnico está en turno activo (soporta turnos nocturnos).

### 6. 📊 Reportes
*   Métricas filtradas por período: Diario, Semanal, Quincenal, Mensual.
*   Gráficas por departamento, tickets más comunes, distribución de estados.
*   Tiempo promedio de resolución calculado.

### 7. ⚙️ Configuración (Settings)
*   CRUD de Departamentos y Sucursales.
*   Validación de integridad referencial antes de eliminar.
*   Invalidación de caché automática al modificar datos maestros.

### 8. 🔔 Notificaciones
*   Campanita In-App con polling (Livewire `wire:poll`).
*   5 tipos de notificaciones: Ticket creado, Crítico (mail + in-app), Status actualizado, Password reset, Perfil actualizado.
*   Toast notifications para feedback inmediato.

### 9. 📝 Auditoría y Logs
*   `ActivityLog`: Trazabilidad de acciones CRUD (crear, editar, eliminar) con modelo polimórfico.
*   `RouteLog`: Registro de navegación HTTP (solo GET, excluye Livewire/debug).
*   Ambos sistemas son fail-safe (no rompen la aplicación si falla el logging).

### 10. 📈 Dashboard
*   Gráficas interactivas filtradas por Día/Semana/Mes.
*   `TicketStatsService` con queries optimizadas por aggregate SQL.
*   Vista adaptada por rol (admins ven todo, usuarios ven solo lo propio).

---

## 🔔 Sistema de Notificaciones y Tiempo Real

El proyecto está diseñado para funcionar dinámicamente sin recargar la página, utilizando **Polling de Livewire** (`wire:poll`):

*   **Campanita (In-App):** Ubicada en la barra de navegación. Notifica cambios de estado y asignaciones en tiempo real.
*   **Notificaciones Críticas (Observer):** Si un ticket se levanta con prioridad "Crítica", el `TicketObserver` dispara una alerta por Correo Electrónico (procesada por las Colas de Laravel) a todos los Administradores.
*   **Dashboard en Vivo:** Las tablas reflejan los cambios que hagan otros usuarios instantáneamente.

---

## 🏗️ Arquitectura y Patrones

```
app/
├── Actions/          ← Business logic actions (Single Responsibility)
├── Http/Middleware/   ← CheckRole, CheckUserStatus, LogRouteRequests
├── Livewire/         ← 16 componentes reactivos (UI + Controller)
├── Models/           ← 12 modelos Eloquent con relaciones
├── Notifications/    ← 5 canales de notificación
├── Observers/        ← Event-driven (TicketObserver)
├── Policies/         ← Authorization gates (2 policies)
├── Services/         ← Business services (3 servicios)
└── Providers/        ← Service + Volt providers
```

**Patrones utilizados:**
*   **Action Pattern:** `CreateTicketAction` para desacoplar lógica del componente.
*   **Observer Pattern:** `TicketObserver` para eventos del ciclo de vida.
*   **Service Layer:** `ScheduleService`, `TicketStatsService`, `ActivityLogger`.
*   **Policy Authorization:** Control de acceso basado en propiedad y roles.
*   **Soft Deletes:** Preservación de datos históricos en tablas clave.

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
    APP_NAME="Suraki HelpDesk"
    DB_CONNECTION=mysql
    DB_DATABASE=suraki_helpdesk
    DB_PASSWORD=tu_contraseña_segura
    QUEUE_CONNECTION=database
    SESSION_ENCRYPT=true
    ```
4.  **Generar Key y Migrar:**
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```
    *(El seeder creará 6 sucursales, 6 departamentos, 1 usuario admin `admin_sistemas` con clave `password`, y 6 equipos de ejemplo).*
5.  **Compilar Assets (Tailwind):**
    ```bash
    npm run build
    ```
6.  **Levantar el Trabajador de Colas:** (Obligatorio para correos)
    ```bash
    php artisan queue:work
    ```
7.  **Desarrollo rápido** (Servidor + Queue + Logs + Vite en un comando):
    ```bash
    composer dev
    ```

---

## 📊 Métricas del Proyecto

| Métrica | Valor |
|---------|-------|
| Modelos Eloquent | 12 |
| Componentes Livewire | 16 |
| Rutas | 24 (18 web + 6 auth) |
| Migraciones | 12 |
| Services | 3 |
| Policies | 2 |
| Notifications | 5 |
| Tests Feature | 4 |
| Seeders | 5 |

---

## 🚀 Hoja de Ruta y Mejoras Pendientes

Tras la auditoría arquitectónica v2 (Junio 2026), se plantean las siguientes optimizaciones:

*   **Refactorización de Reportes:** Migrar cálculos de stats de PHP (in-memory) a aggregate queries SQL para mejor rendimiento.
*   **Optimización de Caché:** Corregir invalidación prematura en InventoryList y aplicar caché consistente en UserList.
*   **Action Pattern extensivo:** Extraer lógica de `RequestForm::save()` y `UserForm::save()` a clases Action.
*   **PHP Enums:** Reemplazar strings hardcoded de status/priority/role por Enum classes.
*   **Tests ampliados:** Cubrir módulos de Requests, Inventory, Users y Schedules.
*   **2FA para administradores:** Autenticación de dos factores.
*   **API REST:** Preparar endpoints para futura app móvil.
*   **Dark Mode:** Toggle de tema oscuro/claro.
*   **Purga automática de logs:** Comando Artisan schedulado para limpiar logs > 90 días.

---

## 📜 Historial de Cambios (Changelog)

### Fase 1: Inicialización y Arquitectura Base
*   Levantar Laravel 13.8, Livewire 3.6, BDD y autenticación básica de Breeze.

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

### Fase 6: Expansión Funcional
*   **Requerimientos:** Módulo Requests con wizard de 3 pasos, asignaciones, comprobantes y comentarios.
*   **Inventario:** Módulo `Device` con CRUD, importación Excel y estadísticas cacheadas.
*   **Horarios:** Control de turnos internos (`UserSchedule`) y outsourcing (`WorkShift`).
*   **Logs:** `activity_logs` y `route_logs` para control y trazabilidad.
*   **Configuración:** CRUD de departamentos y sucursales.

### Fase 7: Hardening y Performance (Junio 2026)
*   Índices de rendimiento en `tickets` y `users`.
*   Soft Deletes en tablas clave (`users`, `tickets`, `devices`, `requests`).
*   Action Pattern (`CreateTicketAction`) con auto-asignación inteligente.
*   Service Layer (`ScheduleService`, `TicketStatsService`, `ActivityLogger`).
*   Tests automatizados para Actions y Policies.
*   Reportes con filtro temporal y métricas de resolución.
