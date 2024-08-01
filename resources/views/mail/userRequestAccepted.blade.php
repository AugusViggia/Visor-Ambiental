@component('mail::message')
¡Hola **{{$user->name}}**!

Se aceptó tu solicitud de cuenta de usuario.

Ahora puedes ingresar al sistema con tus credenciales de acceso (email y contraseña).

@component('mail::button', ['url' => $url])
Ingresar
@endcomponent

**Recordá que:**

- Si no solicitaste una cuenta de usuario, ignora este correo.


**Administrador del sistema**                                                                                                                                                       
Sistema {{ config('app.name')}}

@endcomponent

