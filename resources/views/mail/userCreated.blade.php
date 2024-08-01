@component('mail::message')
¡Hola **{{$user->name}}**!

Tu cuenta de usuario fue creada con éxito el **{{ $date }}** y se te asignó el rol: **{{ $rol }}.**

Hacé click en el siguiente botón para generar tu contraseña de acceso.

@component('mail::button', ['url' => $url])
Generar Contraseña
@endcomponent

**Recordá que:**
- Una vez generada tu contraseña, podrás acceder al Sistema.
- Si no solicitaste una cuenta de usuario, ignora este correo.
- Este email es válido por el plazo de {{ $hoursLimit }}hs.


**Administrador del sistema**                                                                                                                                                       
Sistema {{ config('app.name')}}

@endcomponent
