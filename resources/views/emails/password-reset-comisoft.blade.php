@php
    $appName = 'Comisoft';
    $userName = method_exists($user, 'getAttribute') ? ($user->name ?? $user->email) : ($user->name ?? $user->email ?? 'Usuario');
@endphp

@component('mail::message')

# Hola {{ $userName }},

Recibimos una solicitud para restablecer tu contraseña en {{ $appName }}.
Si fuiste tú, haz clic en el siguiente botón para crear una nueva contraseña segura:

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
👉 Restablecer contraseña
@endcomponent

Este enlace estará disponible por 60 minutos por motivos de seguridad.

Si no realizaste esta solicitud, simplemente ignora este mensaje.
Tu cuenta permanecerá segura y no se realizará ningún cambio.

Gracias por confiar en {{ $appName }},
el sistema inteligente de gestión de actas y comités.

—
Equipo {{ $appName }}

@slot('subcopy')
@component('mail::subcopy')
Este es un mensaje automático, por favor no respondas a este correo.
@endcomponent
@endslot

@endcomponent


