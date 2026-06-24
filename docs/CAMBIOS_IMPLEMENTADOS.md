# 📋 CHANGELOG — Sistema HelpDesk Suraki
### Registro completo de cambios, nuevas funcionalidades y correcciones
**Autor:** Jeralth C.  
**Proyecto:** Suraki HelpDesk — Sistema de Gestión de Tickets  
**Stack:** Laravel 13.x · Livewire 3 · TailwindCSS · ApexCharts  
**Última actualización:** 21/06/2026

---

## 📌 Índice

1. [Corrección del Sistema de Notificaciones](#1-corrección-del-sistema-de-notificaciones)
2. [Corrección del Avatar de Usuario](#2-corrección-del-avatar-de-usuario)
3. [Sistema de Autenticación por Usuario (No correo)](#3-sistema-de-autenticación-por-usuario-no-correo)
4. [Envío de Credenciales por Correo (SMTP)](#4-envío-de-credenciales-por-correo-smtp)
5. [Recuperación de Contraseña vía Administradores](#5-recuperación-de-contraseña-vía-administradores)
6. [Módulo de Reportes y Analíticas](#6-módulo-de-reportes-y-analíticas)
7. [Sistema de Bitácoras (Auditoría)](#7-sistema-de-bitácoras-auditoría)
8. [Zona Horaria Venezuela](#8-zona-horaria-venezuela)
9. [Mejoras en el Dashboard Principal](#9-mejoras-en-el-dashboard-principal)
10. [Mejoras Visuales Generales](#10-mejoras-visuales-generales)
11. [Módulo de Solicitudes IT y Horarios Inteligentes](#11-módulo-de-solicitudes-it-y-horarios-inteligentes)

---

## 1. Corrección del Sistema de Notificaciones

### Problema
El sistema lanzaba un `ErrorException: Undefined array key "ticket_id"` al acceder a cualquier página que mostrara la campana de notificaciones (`notification-bell.blade.php`, línea 33).

### Causa Raíz
La vista intentaba acceder directamente a `$notification->data['ticket_id']` sin verificar que esa clave existiera en el JSON de la notificación. Algunas notificaciones (como las de contraseña o sistema) no contienen `ticket_id`.

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `app/Livewire/Layout/NotificationBell.php` | Se añadió validación con operador null-coalesce (`??`) para las claves del array `data`. Se mejoró el método `markAsRead` para manejar notificaciones sin `ticket_id`. |
| `resources/views/livewire/layout/notification-bell.blade.php` | Se añadió verificación `isset()` y `?? null` antes de acceder a `$notification->data['ticket_id']`. Se mejoró el renderizado visual del dropdown de notificaciones. |

### Resultado
Las notificaciones ahora funcionan sin errores independientemente del tipo de notificación almacenada.

---

## 2. Corrección del Avatar de Usuario

### Problema
- El avatar del usuario no se mostraba correctamente en la barra superior ni en el perfil.
- Al guardar una imagen de perfil, aparecía un error SQL porque la columna `avatar_path` no existía o no se mapeaba bien.

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `app/Models/User.php` | Se añadió un accessor `getAvatarUrlAttribute()` que resuelve la URL del avatar correctamente usando `Storage::url()`. Se añadió `avatar_path` al array `$fillable`. |
| `resources/views/livewire/profile/update-profile-information-form.blade.php` | Se corrigió la referencia al campo de avatar para que use el accessor del modelo. Se mejoró la previsualización de la imagen. |
| `resources/views/livewire/layout/navigation.blade.php` | Se actualizó el avatar del sidebar para usar `auth()->user()->avatar_url`. |
| `resources/views/layouts/app.blade.php` | Se actualizó el avatar de la barra superior (topbar) para usar el accessor correcto. |

### Resultado
El avatar ahora se muestra correctamente en todas las ubicaciones del sistema (sidebar, topbar, perfil) y se puede actualizar sin errores.

---

## 3. Sistema de Autenticación por Usuario (No correo)

### Problema
El sistema de login por defecto de Laravel Breeze utilizaba el correo electrónico como campo de entrada. El cliente requería que el campo principal de autenticación fuera el **nombre de usuario** (`username`).

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `resources/views/livewire/pages/auth/login.blade.php` | Se cambió el campo `email` por `username`. Se actualizaron las etiquetas y placeholders. Se ajustó la validación del formulario. |

### Resultado
Los usuarios ahora inician sesión con su **usuario** asignado, no con su correo electrónico. El correo queda como dato interno para notificaciones.

---

## 4. Envío de Credenciales por Correo (SMTP)

### Problema
Al crear un usuario nuevo, no se le informaban sus credenciales de acceso. El administrador tenía que comunicarle manualmente su usuario y contraseña.

### Configuración SMTP Utilizada
```
Host: mail.suraki.net
Puerto: 465
Usuario: soporte@suraki.net
Cifrado: SSL
Nombre: "Logistica Citas Suraki"
```

### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Mail/UserCredentialsMail.php` | Mailable que estructura el correo con el usuario y la contraseña en texto plano (generada temporalmente). |
| `resources/views/emails/user-credentials.blade.php` | Plantilla HTML del correo con el logo de Suraki, los datos de acceso y un mensaje de bienvenida. |

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `app/Livewire/Users/UserForm.php` | Al crear un usuario nuevo, se dispara automáticamente el envío del correo con las credenciales al email registrado del departamento. |
| `resources/views/livewire/users/user-form.blade.php` | Se añadió el campo `email` visible al formulario de creación de usuarios. |

### Resultado
Al crear un usuario nuevo, el sistema envía automáticamente un correo al email registrado con su **nombre de usuario** y **contraseña temporal**.

---

## 5. Recuperación de Contraseña vía Administradores

### Problema
No existía mecanismo de recuperación de contraseña. Si un usuario la olvidaba, no había forma de restablecerla dentro del sistema.

### Flujo Implementado
1. El usuario va a la pantalla de login y hace clic en "¿Olvidaste tu contraseña?"
2. Introduce su **nombre de usuario**.
3. Se envía una **notificación interna** (por la campana 🔔) a todos los administradores.
4. El administrador ve la notificación, hace clic, y es redirigido a la pantalla de gestión de usuarios.
5. El administrador actualiza la contraseña del usuario.
6. Se envía automáticamente un correo al usuario con su nueva contraseña.

### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Notifications/PasswordResetAdminNotification.php` | Notificación de tipo `database` que se envía a los administradores cuando un usuario solicita reset de contraseña. |

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `resources/views/livewire/pages/auth/forgot-password.blade.php` | Se rediseñó completamente. Ahora pide el `username` en lugar del email. Muestra un mensaje de confirmación indicando que los administradores fueron notificados. |
| `app/Livewire/Layout/NotificationBell.php` | Se agregó la lógica para redirigir al admin a `/users` cuando hace clic en una notificación de reset de contraseña. |
| `app/Livewire/Users/UserForm.php` | Al actualizar la contraseña de un usuario existente, se envía automáticamente un correo con las nuevas credenciales. |

### Resultado
Flujo completo de reset de contraseña sin necesidad de correo directo al usuario olvidadizo: pasa siempre por los administradores para control.

---

## 6. Módulo de Reportes y Analíticas

### Descripción
Se creó un módulo completo de reportes analíticos accesible desde el menú lateral, destinado a la consulta diaria y a la generación de documentos PDF para auditorías.

### Funcionalidades
- **Filtros de Periodo**: Diario (últimas 24h), Semanal (7 días), Quincenal (15 días), Mensual (30 días).
- **Tarjetas KPI**: Total Creados, Resueltos, Pendientes.
- **Gráficos Interactivos (ApexCharts)**:
  - Barra horizontal: Incidencias por Departamento
  - Donut: Distribución de Estados
  - Barra vertical: Top 5 Incidencias Más Comunes
- **Actualización Asíncrona**: Los gráficos se actualizan SIN recargar la página al cambiar de filtro (usando `$wire.watch` y `updateSeries` de ApexCharts).
- **Tabla Detallada**: Registro de Operaciones con columnas enriquecidas (Detalle del Ticket con descripción, Involucrados con "De/Para", Departamento y Estado con badges de color, Fechas de creación y resolución).
- **Exportación a PDF**: Genera un documento profesional con tablas estadísticas puras en HTML (no depende de canvas/SVG), incluyendo:
  - Encabezado corporativo con periodo y fecha
  - KPI cards con colores
  - Barra de progreso de tasa de resolución
  - Tabla de departamentos con porcentajes
  - Tabla de estados con badges
  - Top 5 con ranking numerado
  - Detalle completo de tickets (8 columnas)
  - Pie de página con nota de confidencialidad

### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Livewire/Reports/Index.php` | Componente Livewire con propiedades reactivas `$deptChart`, `$commonChart`, `$statusChart`, `$metrics`. Métodos `setPeriod()`, `loadData()`. |
| `resources/views/livewire/reports/index.blade.php` | Vista completa con 2 secciones: pantalla interactiva (ApexCharts) y documento PDF oculto (tablas HTML puras con inline styles). |

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `routes/web.php` | Se añadió la ruta `/reports` protegida por middleware `auth`. |
| `resources/views/livewire/layout/navigation.blade.php` | Se añadió el enlace "Reportes" con ícono al menú lateral del sidebar. |
| `resources/views/layouts/app.blade.php` | Se añadieron los CDN de ApexCharts y html2pdf.js en el `<head>`. |

### Dependencias Externas (CDN)
- **ApexCharts**: `https://cdn.jsdelivr.net/npm/apexcharts` — Gráficos interactivos en pantalla.
- **html2pdf.js**: `https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js` — Exportación a PDF.

---

## 7. Sistema de Bitácoras (Auditoría)

### Descripción
Se implementó un sistema de auditoría dual que registra automáticamente todas las acciones realizadas por los usuarios y todas las rutas navegadas dentro del sistema.

### Componente 1: Bitácora de Acciones (`ActivityLog`)

Registra eventos del sistema como:
- Creación de usuarios
- Creación de tickets
- Comentarios en tickets
- Cambios de estado de tickets
- Actualizaciones de contraseña

#### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Models/ActivityLog.php` | Modelo Eloquent con método estático `log($action, $description, $userId)` para registrar eventos desde cualquier parte del código. |
| `database/migrations/2026_06_21_012413_create_activity_logs_table.php` | Migración: columnas `user_id`, `action`, `description`, `ip_address`, `user_agent`, `timestamps`. |

#### Integración
Se añadieron llamadas a `ActivityLog::log()` en:
- `app/Livewire/Users/UserForm.php` → Al crear/actualizar usuarios
- `app/Livewire/Tickets/TicketForm.php` → Al crear tickets
- `app/Livewire/Tickets/TicketDetail.php` → Al comentar o cambiar estado

### Componente 2: Bitácora de Rutas (`RouteLog`)

Registra de forma silenciosa cada navegación del usuario dentro del sistema (URL visitada, método HTTP, IP, timestamp).

#### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Models/RouteLog.php` | Modelo Eloquent para el registro de rutas. |
| `database/migrations/2026_06_21_012418_create_route_logs_table.php` | Migración: columnas `user_id`, `url`, `method`, `ip_address`, `user_agent`, `timestamps`. |
| `app/Http/Middleware/LogRouteAccess.php` | Middleware global que intercepta cada petición HTTP autenticada y la registra en la tabla `route_logs`. |

#### Registro del Middleware
| Archivo | Cambio |
|---|---|
| `bootstrap/app.php` | Se registró `LogRouteAccess::class` en el pipeline global de middleware con `->append()`. |

### Interfaz de Consulta
| Archivo | Descripción |
|---|---|
| `app/Livewire/Bitacora/Index.php` | Componente Livewire con dos pestañas: "Acciones" y "Rutas". Incluye paginación y búsqueda. |
| `resources/views/livewire/bitacora/index.blade.php` | Vista con tabs, tablas con los registros, iconos, colores por tipo de acción, y timestamps formateados. |

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `routes/web.php` | Se añadió la ruta `/bitacora` protegida por middleware `auth`. |
| `resources/views/livewire/layout/navigation.blade.php` | Se añadió el enlace "Bitácora" con ícono al sidebar. |

---

## 8. Zona Horaria Venezuela

### Problema
El sistema estaba configurado en UTC (hora de Greenwich). Todas las fechas y horas mostradas estaban desfasadas -4 horas respecto a Venezuela.

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `config/app.php` | Se cambió `'timezone' => 'UTC'` por `'timezone' => 'America/Caracas'`. |
| `app/Livewire/Reports/Index.php` | Se cambió el filtro "Diario" de `whereDate()` a `where('created_at', '>=', subDay())` para evitar inconsistencias con registros almacenados en UTC antes del cambio de zona horaria. |

### Resultado
Todas las fechas del sistema (notificaciones, tickets, bitácora, reportes) ahora muestran la hora correcta de Venezuela (UTC-4).

---

## 9. Mejoras en el Dashboard Principal

### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Livewire/Dashboard/Index.php` | Nuevo componente Livewire que maneja las métricas del dashboard: totales, tendencias mensuales, distribución por departamento y rendimiento de agentes. |
| `resources/views/livewire/dashboard/index.blade.php` | Vista con tarjetas KPI, gráficos de tendencias y distribución, tabla de rendimiento de agentes. |

### Archivos Modificados
| Archivo | Cambio |
|---|---|
| `resources/views/dashboard.blade.php` | Se reemplazó el contenido estático por el componente Livewire `<livewire:dashboard.index />`. |

---

## 10. Mejoras Visuales Generales

### Detalle de Ticket (`ticket-detail.blade.php`)
- Se mejoró el diseño del modal/vista de detalle con mejor estructura de información.
- Se añadieron badges de color para los estados.
- Se mejoró la sección de comentarios con avatares y timestamps.
- Se añadió funcionalidad de cambio de estado directamente desde el detalle.

### Inventario (`inventory-list.blade.php`)
- Se mejoró el listado visual de activos fijos.
- Se creó `InventoryForm.php` para el formulario de creación/edición de inventario.

### Lista de Tickets (`ticket-list.blade.php`)
- Se añadió funcionalidad de búsqueda y filtrado.
- Se mejoró la tabla con más información visual.

### Lista de Usuarios (`user-list.blade.php`)
- Se mejoró el diseño de la tabla de usuarios.
- Se añadieron acciones rápidas por fila.

### Sidebar Navigation (`navigation.blade.php`)
- Se añadieron los nuevos enlaces: Reportes, Bitácora, Configuración.
- Se mejoró el diseño responsive y la animación de colapso.

---

## 11. Módulo de Solicitudes IT y Horarios Inteligentes

### Descripción
Se reemplazó el antiguo módulo de "Bitácora" por un completo sistema de **Solicitudes IT** y un gestor inteligente de **Horarios y Control Outsourcing** para el departamento de Sistemas.

### Funcionalidades Implementadas
- **Solicitudes IT:** Los usuarios pueden solicitar equipamiento de hardware mediante un formulario. Los administradores tienen un panel con pestañas interactivas (Pendientes, Aprobados, Rechazados) que funciona en tiempo real (asíncrono con polling).
- **Gestión de Horarios (Internos vs Outsourcing):** Se creó un módulo para administrar esquemas laborales. Los administradores pueden asignar un horario fijo semanal al personal interno o establecerlos como "Outsourcing" (horarios flexibles).
- **Control de Asistencia Outsourcing:** Un panel de "Check-In" para que el personal flexible registre sus horas reales de trabajo con exactitud (Llegada/Salida).
- **Asignación Inteligente de Tickets:** El motor de asignación de nuevos tickets ahora verifica los horarios en tiempo real. Los tickets **solo** se asignan a administradores que estén activamente **"En Turno"** en el momento de la creación. Si nadie está en turno, el ticket queda "Abierto" y al usuario se le muestra una alerta advirtiendo que está fuera del horario laboral.

### Archivos Creados
| Archivo | Descripción |
|---|---|
| `app/Models/UserSchedule.php` | Modelo para gestionar contratos y horas fijas. |
| `app/Models/WorkShift.php` | Modelo para gestionar turnos asíncronos y asistencia. |
| `app/Livewire/Horarios/...` | Componentes Livewire `HorariosList`, `HorariosForm`, `WorkShiftsList`. |
| `database/migrations/...` | Migraciones `create_user_schedules_table`, `create_work_shifts_table`, `create_solicitudes_table`. |

---

## 📁 Resumen de Archivos

### Archivos Nuevos (Creados desde cero)
```
app/Http/Middleware/LogRouteAccess.php
app/Livewire/Bitacora/Index.php
app/Livewire/Dashboard/Index.php
app/Livewire/Inventory/InventoryForm.php
app/Livewire/Reports/Index.php
app/Livewire/Settings/Index.php
app/Mail/UserCredentialsMail.php
app/Models/ActivityLog.php
app/Models/RouteLog.php
app/Notifications/PasswordResetAdminNotification.php
app/Notifications/TicketCreated.php
database/migrations/2026_06_21_012413_create_activity_logs_table.php
database/migrations/2026_06_21_012418_create_route_logs_table.php
resources/views/emails/user-credentials.blade.php
resources/views/livewire/bitacora/index.blade.php
resources/views/livewire/dashboard/index.blade.php
resources/views/livewire/inventory/inventory-form.blade.php
resources/views/livewire/reports/index.blade.php
resources/views/livewire/settings/index.blade.php
```

### Archivos Modificados
```
app/Livewire/Inventory/InventoryList.php
app/Livewire/Layout/NotificationBell.php
app/Livewire/Tickets/TicketDetail.php
app/Livewire/Tickets/TicketForm.php
app/Livewire/Tickets/TicketList.php
app/Livewire/Users/UserForm.php
app/Models/User.php
bootstrap/app.php
config/app.php
resources/views/dashboard.blade.php
resources/views/layouts/app.blade.php
resources/views/livewire/inventory/inventory-list.blade.php
resources/views/livewire/layout/navigation.blade.php
resources/views/livewire/layout/notification-bell.blade.php
resources/views/livewire/pages/auth/forgot-password.blade.php
resources/views/livewire/pages/auth/login.blade.php
resources/views/livewire/profile/update-profile-information-form.blade.php
resources/views/livewire/tickets/ticket-detail.blade.php
resources/views/livewire/tickets/ticket-form.blade.php
resources/views/livewire/tickets/ticket-list.blade.php
resources/views/livewire/users/user-form.blade.php
resources/views/livewire/users/user-list.blade.php
routes/web.php
```

---

## 🔧 Dependencias Añadidas

| Dependencia | Tipo | Uso |
|---|---|---|
| ApexCharts | CDN (JS) | Gráficos interactivos en Dashboard y Reportes |
| html2pdf.js | CDN (JS) | Exportación de reportes a PDF |

---

## 🗄️ Migraciones de Base de Datos

| Migración | Tabla | Descripción |
|---|---|---|
| `2026_06_21_012413_create_activity_logs_table.php` | `activity_logs` | Registro de acciones del sistema (auditoría) |
| `2026_06_21_012418_create_route_logs_table.php` | `route_logs` | Registro de navegación de usuarios |

---

## 🛣️ Rutas Nuevas

| Ruta | Método | Componente | Descripción |
|---|---|---|---|
| `/reports` | GET | `Reports\Index` | Módulo de reportes y analíticas |
| `/bitacora` | GET | `Bitacora\Index` | Sistema de bitácoras de auditoría |

---

> **Nota:** Este documento refleja TODOS los cambios realizados hasta el 20/06/2026. Cualquier cambio posterior será documentado como una nueva entrada en el changelog.
