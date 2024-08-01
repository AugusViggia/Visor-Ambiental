@component('mail::message')
¡Hola **{{$user->name}}**!

Se rechazó tu solicitud de cuenta de usuario por el siguiente motivo:

**{{ $reason }}**

**Recordá que:**

- Si no solicitaste una cuenta de usuario, ignora este correo.


**Administrador del sistema**                                                                                                                                                                                                                                                              
Sistema {{ config('app.name')}}

@endcomponent

