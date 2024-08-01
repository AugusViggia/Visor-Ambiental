<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':Attribute deben aceptarse.',
    'accepted_if' => ':Attribute debe aceptarse cuando :other es :value.',
    'active_url' => ':Attribute no es una URL válida.',
    'after' => ':Attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => ':Attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => ':Attribute debe contener solo letras.',
    'alpha_dash' => ':Attribute únicamente acepta: letras, números, guiones y guiones bajos.',
    'alpha_num' => ':Attribute únicamente acepta letras y números.',
    'array' => ':Attribute debe ser una lista.',
    'before' => ':Attribute debe ser anterior a :date.',
    'before_or_equal' => ':Attribute debe ser anterior o igual a :date.',
    'between' => [
        'array' => ':Attribute debe tener entre :min y :max elementos.',
        'file' => ':Attribute debe ser de :min a :max kilobytes.',
        'numeric' => ':Attribute debe estar entre :min y :max.',
        'string' => ':Attribute debe tener entre :min y :max caracteres.',
    ],
    'boolean' => ':Attribute debe ser verdadero o falso (SI o NO).',
    'confirmed' => 'El campo :attribute y su confirmación no coinciden.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => ':Attribute no es una fecha válida.',
    'date_equals' => ':Attribute debe ser una fecha igual a :date.',
    'date_format' => ':Attribute no coincide con el formato :format.',
    'declined' => ':Attribute debe declinarse.',
    'declined_if' => ':Attribute debe declinarse cuando :other es :value.',
    'different' => ':Attribute y :Other deben ser diferentes.',
    'digits' => ':Attribute debe tener :digits digitos.',
    'digits_between' => ':Attribute tener entre :min y :max digitos.',
    'dimensions' => ':Attribute, la imagen tiene dimensiones no válidas.',
    'distinct' => ':Attribute tiene un valor duplicado.',
    'email' => ':Attribute debe ser un email válido.',
    'ends_with' => ':Attribute debe terminar en uno del/los siguiente/s :values.',
    'enum' => 'El :attribute elegido no es válido.',
    'exists' => 'La elección de :attribute no es válida.',
    'file' => ':Attribute debe ser un archivo.',
    'filled' => ':Attribute debe tener un valor.',
    'gt' => [
        'array' => ':Attribute debe tener mas de :value items.',
        'file' => ':Attribute debe ser mayor que :value kilobytes.',
        'numeric' => ':Attribute debe ser mayor que :value.',
        'string' => ':Attribute debe tener mas de :value caracteres.',
    ],
    'gte' => [
        'array' => ':Attribute debe tener :value o más items.',
        'file' => ':Attribute debe ser mayor o igual a :value kilobytes.',
        'numeric' => ':Attribute debe ser mayor o igual a :value.',
        'string' => 'La cantidad de caracteres del campo :Attribute debe ser mayor o igual a :value.',
    ],
    'image' => ':Attribute debe ser una imagen.',
    'in' => 'La selección de :attribute no es válida.',
    'in_array' => 'El  campo :Attribute no existe en :other.',
    'integer' => ':Attribute debe ser un número entero.',
    'ip' => ':Attribute debe ser una IP válida.',
    'ipv4' => ':Attribute debe ser una IPv4 válida.',
    'ipv6' => ':Attribute debe ser una IPv6 válida.',
    'json' => ':Attribute debe ser una cadena JSON válida.',
    'lt' => [
        'array' => ':Attribute debe tener menos de :value items.',
        'file' => ':Attribute debe ser menor a :value kilobytes.',
        'numeric' => ':Attribute debe ser menor a :value.',
        'string' => ':Attribute debe tener menos de :value caracteres.',
    ],
    'lte' => [
        'array' => ':Attribute no debe tener mas de :value items.',
        'file' => ':Attribute debe ser menor o igual a :value kilobytes.',
        'numeric' => ':Attribute debe ser menor o igual a :value.',
        'string' => 'La cantidad de caracteres de :Attribute debe ser menor o igual a :value.',
    ],
    'mac_address' => ':Attribute debe ser una MAC address válida.',
    'max' => [
        'array' => ':Attribute no debe tener mas de :max items.',
        'file' => ':Attribute no debe superar los :max kilobytes.',
        'numeric' => ':Attribute no debe ser mayor a :max.',
        'string' => 'La cantidad de caracteres de :Attribute no debe ser mayor a :max.',
    ],
    'mimes' => ':Attribute debe ser un archivo de tipo: :values.',
    'mimetypes' => ':Attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => ':Attribute debe tener al menos :min items.',
        'file' => ':Attribute debe ser de al menos :min kilobytes.',
        'numeric' => ':Attribute debe ser al menos :min.',
        'string' => ':Attribute debe tener al menos :min caracteres.',
    ],
    'multiple_of' => ':Attribute debe ser un múltipiplo de :value.',
    'not_in' => 'La selección para :attribute no es válida.',
    'not_regex' => ':Attribute, su formato no es válido.',
    'numeric' => ':Attributedebe ser un número.',
    'present' => ':Attribute debe estar presente.',
    'prohibited' => ':Attribute no se permite.',
    'prohibited_if' => ':Attribute no se permite cuando :other es :value.',
    'prohibited_unless' => ':Attribute no se permite a menos que :other este entre :values.',
    'prohibits' => ':Attribute prohibe a :other si está presente.',
    'regex' => ':Attribute el formato no es válido.',
    'required' => ':Attribute es requerido.',
    'required_array_keys' => ':Attribute debe contener entradas para: :values.',
    'required_if' => 'Se requiere:Attribute cuando :other es :value.',
    'required_unless' => ':Attribute se requiere a menos que :other esté entre :values.',
    'required_with' => ':Attribute se requiere cuando :values está/n presente/s.',
    'required_with_all' => ':Attribute se requiere cuando los :values están presentes.',
    'required_without' => ':Attribute se requiere cuando :values no están presentes.',
    'required_without_all' => ':Attribute se requiere cuando ninguno de estos valores: :values están presentes.',
    'same' => ':Attribute y :other deben coincidir.',
    'size' => [
        'array' => ':Attribute debe contener :size items.',
        'file' => ':Attribute debe ser de :size kilobytes.',
        'numeric' => ':Attribute debe ser :size.',
        'string' => ':Attribute debe sed de :size caracteres.',
    ],
    'starts_with' => ':Attribute debe comenzar con uno de los siguientes valores: :values.',
    'string' => ':Attribute debe ser una cadena de texto.',
    'timezone' => ':Attribute debe ser una zona horaria válida.',
    'unique' => ':Attribute ya se encuentra en uso.',
    'uploaded' => ':Attribute falló la subida.',
    'url' => ':Attribute debe ser una URL válida.',
    'uuid' => ':Attribute debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'current_password' => 'Contraseña actual',
        'document_number' => 'Número de documento',
        'institution' => 'Institución',
        'name' => 'nombre y apellido',
        'password' => 'contraseña',
        'terms' => 'Los Términos del Servicio y las Políticas de Privacidad',
        'reason' => 'Motivo',
        'category_id' => 'categoría',
        'subcategory_id' => 'subcategoría',
        'role_id' => 'Rol',
        'ecoregion_id' => 'Ecorregión',
        'geometry_id' => 'geometría',
        'title' => 'título',
        'source' => 'fuente',
        'url' => 'web',
        'altitude' => 'altura',
        'latitude' => 'latitud',
        'longitude' => 'longitud',
        'observations' => 'observaciones',
        'taxa' => 'Nro. Taxones',
        'description' => 'descripción',
        'date' => 'fecha',
        'today' => 'fecha actual'
    ],

];
