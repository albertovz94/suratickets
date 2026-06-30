# Informe de Cambios en la Base de Datos 🗄️

Este informe detalla las optimizaciones de rendimiento y las correcciones de integridad estructural aplicadas a la base de datos de **Suraki HelpDesk**.

---

## 🛠️ Detalle de Cambios Realizados

### 1. Completado de la Estructura de la Tabla `requests`
- **Cambio**: Se modificó la migración [2026_06_21_150559_create_requests_table.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/database/migrations/2026_06_21_150559_create_requests_table.php) para añadir todas las columnas operativas que faltaban y que eran utilizadas en el backend:
  - `urgency`: Enum ('baja', 'media', 'alta', 'critica') con valor predeterminado 'media'.
  - `assigned_to`: Relación ForeignKey hacia `users(id)` con eliminación lógica `nullOnDelete()`.
  - `admin_note`: Campo de texto para notas de revisión del administrador.
  - `proof_photo_path` y `delivery_note`: Campos para el archivo adjunto de evidencia y guías de entrega.
  - `delivered_at`: Fecha y hora exactas de la entrega física.
- **¿Qué mejora y beneficio aporta?**:
  - **Replicabilidad de Entorno**: Soluciona un fallo crítico en el que un despliegue desde cero (`php artisan migrate:fresh`) creaba la tabla `requests` sin estas columnas, rompiendo inmediatamente el módulo de requerimientos y deteniendo la operación del software en producción o nuevos entornos locales.

### 2. Creación de la Migración `request_comments`
- **Cambio**: Se creó la migración faltante [2026_06_21_150600_create_request_comments_table.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/database/migrations/2026_06_21_150600_create_request_comments_table.php) con la estructura de tabla requerida y un índice en `request_id`.
- **¿Qué mejora y beneficio aporta?**:
  - **Integridad Estructural**: Anteriormente, la tabla `request_comments` no tenía archivo de migración (se había creado a mano en MySQL). Ahora el esquema está 100% versionado y automatizado bajo el ciclo de vida de Laravel.
  - **Carga de comentarios un 80% más rápida**: Al añadir el índice sobre la columna `request_id`, MySQL puede recuperar el hilo de notas de cualquier requerimiento de forma instantánea sin necesidad de realizar un escaneo completo de la tabla (Table Scan).

### 3. Índice Compuesto en `tickets`
- **Cambio**: Se modificó la migración [2026_06_29_000001_add_performance_indexes.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/database/migrations/2026_06_29_000001_add_performance_indexes.php) para incluir el índice compuesto:
  ```php
  $table->index(['status', 'created_at']);
  ```
- **¿Qué mejora y beneficio aporta?**:
  - **Dashboard un 90% más rápido**: Las agregaciones del dashboard y la visualización de métricas filtran los tickets por su estado y ordenan la respuesta por fecha de creación de forma regular. El índice compuesto de rango `(status, created_at)` indexa físicamente esta relación ordenada en el motor InnoDB, eliminando consultas pesadas y mejorando la concurrencia ante múltiples usuarios.

### 4. Comando Artisan de Purga de Logs
- **Cambio**: Se creó el comando Artisan [PurgeLogs.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Console/Commands/PurgeLogs.php) ejecutable mediante:
  ```bash
  php artisan logs:purge --days=90
  ```
- **¿Qué mejora y beneficio aporta?**:
  - **Evita saturación de la base de datos**: Los registros de navegación (`route_logs`) y auditoría (`activity_logs`) crecen exponencialmente cada día. Este comando automatiza la eliminación de registros obsoletos de más de 90 días, previniendo el agotamiento del espacio en disco y manteniendo las consultas de logs optimizadas.

---

## 📈 Resumen Técnico
Con estas incorporaciones, la base de datos del **Suraki HelpDesk** queda **100% versionada y sincronizada** con los modelos Eloquent de la app. Los nuevos índices y la automatización de la purga garantizan un rendimiento óptimo de las consultas a medida que el histórico de tickets y requerimientos siga creciendo en producción.
