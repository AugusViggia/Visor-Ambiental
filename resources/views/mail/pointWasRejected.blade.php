@component('mail::message')
¡Hola **{{$user->name}}**!

Rechazamos tu solicitud de alta de punto debido a:

**{{ $reason }}**

Recordá que:

Si no realizaste el alta de un punto, ignorá este correo.

**Administrador del sistema**                                       
Sistema {{ config('app.name')}}

@endcomponent
