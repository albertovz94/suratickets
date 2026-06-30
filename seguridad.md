# Informe de Cambios de Seguridad Implementados 🔒

Este informe resume los cambios de seguridad aplicados al proyecto **Suraki HelpDesk** para robustecer el entorno de desarrollo y prepararlo adecuadamente, mitigando vectores comunes de ataque.

---

## 🛠️ Detalle de Cambios Realizados

### 1. Encriptación de Datos de Sesión
- **Cambio**: Se modificaron los archivos de configuración de entorno [.env](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/.env) y [.env.example](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/.env.example) estableciendo:
  ```env
  SESSION_ENCRYPT=true
  ```
- **¿Qué mejora?**:
  - **Protección contra filtración de base de datos**: Dado que el sistema utiliza el driver `database` para almacenar sesiones en MySQL, antes de este cambio toda la información de la sesión activa del usuario (incluyendo tokens de autenticación, datos temporales y estados del sistema) se guardaba como texto plano JSON legible en la tabla `sessions`.
  - **Mitigación de Secuestro de Sesión (Session Hijacking)**: Si un atacante tuviera acceso de lectura a la base de datos (por ejemplo, a través de una inyección SQL o credenciales débiles en el servidor), no podrá reconstruir el payload ni robar el token de autenticación del usuario, ya que los valores ahora son encriptados automáticamente mediante la clave de cifrado de la aplicación (`APP_KEY`).

### 2. Validación Estricta de Subida de Archivos (Upload Security)
- **Cambio**: Se modificaron las reglas de validación del campo de adjunto (`attachment`) en los formularios reactivos de tickets:
  - [TicketForm.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Livewire/Tickets/TicketForm.php)
  - [TicketDetail.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Livewire/Tickets/TicketDetail.php)
  - Se cambió la regla de validación original a:
    ```php
    'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,zip,rar,txt|max:10240',
    ```
- **¿Qué mejora?**:
  - **Prevención de Ejecución de Código Remoto (RCE)**: Antes, un usuario malintencionado podía subir cualquier extensión de archivo (por ejemplo, scripts PHP como `shell.php`, scripts bash, etc.). Si el servidor web procesa la carpeta pública de almacenamiento y el atacante accede directamente a la URL del archivo, el servidor ejecutaría el script malicioso dándole control total sobre el servidor web. Al restringir las extensiones a una lista blanca de mimes seguros (imágenes, PDFs, documentos de Office y comprimidos), se neutraliza por completo este vector de ataque.
  - **Mitigación de Stored XSS**: Evita la carga de archivos HTML (`.html`) o archivos SVG con scripts incrustados que, al abrirse directamente en el navegador del administrador de TI, pudiesen robar cookies de sesión o realizar acciones en nombre del administrador.

### 3. Parche de Contexto de Usuario en Comentarios de Requerimientos
- **Cambio**: Se corrigió el error en el controlador del listado de requerimientos:
  - [RequestList.php](file:///c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Livewire/Requests/RequestList.php)
  - Se reemplazó la variable inexistente `$user->id` por la función de autenticación de Laravel `auth()->id()`.
- **¿Qué mejora?**:
  - **Estabilidad y Seguridad**: Previene excepciones no controladas de PHP al interactuar con el hilo de comentarios. Los errores de php no capturados pueden exponer información de depuración sensible (trazas de la base de datos, rutas del servidor) si `APP_DEBUG` está encendido por accidente. Al corregir esto, se asegura que el identificador del creador del comentario sea el del usuario autenticado de forma limpia y confiable.

---

## 📈 Conclusiones
Estas mejoras protegen los tres pilares principales de interacción externa de la app: **las sesiones en el almacén de datos (BD)**, **el sistema de transferencia de archivos (Uploads)**, y **la lógica del flujo de datos en formularios**. El proyecto ahora se encuentra en un estado mucho más seguro para su operación.
