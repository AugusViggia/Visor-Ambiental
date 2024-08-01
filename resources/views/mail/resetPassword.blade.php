@component('mail::message')
¡Hola **{{$user->name}}**!

Hacé clic en el siguiente botón para recuperar tu contraseña:

@component('mail::button', ['url' => $url])
Recuperar Contraseña
@endcomponent

**Recordá que:**
- Este email es válido por el plazo de {{$count}} horas. Pasado este tiempo, deberás volver a solicitar la recuperación de tu contraseña desde el Sistema
- Una vez generada tu contraseña, podrás acceder al Sistema.
- Si no solicitaste la recuperación de tu contraseña, ignora este correo.


**Administrador del sistema**                                                                                                                                                       
Sistema {{ config('app.name')}}

@endcomponent



