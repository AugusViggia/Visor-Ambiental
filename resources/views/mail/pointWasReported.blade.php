@component('mail::message')
¡Hola **{{$user->name}}**!

El punto: {{ $point->id }}

**Título:** {{ $point->title }}
**Descripcion:** {{ $point->description }}

fue denunciado y dado de baja momentáneamente por el siguiente motivo:

**{{ $reason }}**

Le pedimos que modifique lo solicitado a la brevedad. De manera que el punto sea publicado nuevamente con la información correcta.

Cualquier inconveniente comuníquese con nosotros y lo resolveremos.

Gracias

{{ config('app.name')}}
@endcomponent

