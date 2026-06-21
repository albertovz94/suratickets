<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tus Credenciales de Acceso</title>
    <style>
        body { font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #1e293b; line-height: 1.6; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-top: 4px solid #e11d48; }
        .header { text-align: center; margin-bottom: 24px; }
        .title { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .content { font-size: 16px; color: #334155; }
        .credentials-box { background-color: #f1f5f9; border-radius: 8px; padding: 20px; margin: 24px 0; border: 1px solid #e2e8f0; }
        .label { font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600; margin-bottom: 4px; }
        .value { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; font-family: monospace; }
        .value:last-child { margin-bottom: 0; }
        .button-container { text-align: center; margin-top: 32px; }
        .button { display: inline-block; background-color: #e11d48; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; text-align: center; }
        .button:hover { background-color: #be123c; }
        .footer { margin-top: 32px; font-size: 12px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">¡Bienvenido a {{ config('app.name') }}!</h1>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $user->name }}</strong>,</p>
            <p>Tu cuenta de usuario ha sido creada y configurada exitosamente por el administrador del sistema.</p>
            
            <p>A continuación, te enviamos tus credenciales de acceso para que puedas iniciar sesión y empezar a utilizar la plataforma:</p>
            
            <div class="credentials-box">
                <div class="label">Correo Electrónico / Usuario</div>
                <div class="value">{{ $user->email }} @if($user->username) / {{ $user->username }} @endif</div>
                
                <div class="label">Contraseña</div>
                <div class="value">{{ $plainPassword }}</div>
                
                <div class="label">Departamento Asignado</div>
                <div class="value">{{ $user->departamento ? $user->departamento->nombre : 'N/A' }}</div>
            </div>
            
            <p>Por motivos de seguridad, te recomendamos iniciar sesión lo antes posible y cambiar tu contraseña desde tu panel de perfil.</p>
            
            <div class="button-container">
                <a href="{{ url('/login') }}" class="button" style="color:white;">Iniciar Sesión Ahora</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Este es un correo automático generado por el sistema. Por favor no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
