<?php

return [
    'map' => [
        'ecoregion_layer_colors' => [
            'altos-andes' => '#b0cad9',
            'puna' => '#45a3af',
            'yungas' => '#f6b5d3',
            'chaco-seco' => '#f07d00',
            'monte-de-sierras-y-bolsones' => '#fdcd01',
            'default' => '#ccc'
        ],
        'statics_layer_sources' => [
            [
                'id' => 'pipelines',
                'name' => 'Catastros Mineros',
                'file' => 'layers/mining.json',
                'color' => '#990000',
            ],
            [
                'id' => 'mining',
                'name' => 'Gasoductos',
                'file' => 'layers/pipelines.json',
                'color' => '#4B5D67',
            ],
        ],
    ],

    'file_uploads' => [
        'csv_mimes' => 'text/csv,text/plain,csv,txt',
    ],

    'admin' => [
        'request_types' => [
            [
                'type' => 'pending',
                'name' => 'Pendientes de Aprobación',
                'order_field' => 'requested_at',
                'order_type' => 'desc',
            ],
            [
                'type' => 'rejected',
                'name' => 'Rechazadas',
                'order_field' => 'deleted_at',
                'order_type' => 'desc',
            ],
        ],
    ],

    'points' => [
        'status' => [
            'pending' => 1,
            'approved' => 2,
            'denounced' => 3,
            'rejected' => 4,
        ],
        'category' => [
            'category_default_id' => 1,
        ],
        'deleteAdmin' => [
            'denounced' => 3,
            'rejected' => 4,
        ],
        'deleteUser' => [
            'pending' => 1,
            'denounced' => 3,
            'rejected' => 4,
        ],
        'validation' => [
            'latitude' => [
                'regex' => '/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',
            ],
            'longitude' => [
                'regex' => '/^[-]?((1[0-7][0-9])\.(\d+))|([0-9]?[0-9])\.(\d+)|(180(\.0+)?)$/',
            ],
        ],
    ],

    'imports' => [

        'models_imports' => [
            \App\Models\Point::class => \App\Imports\PointsImport::class,
        ],

        'models_import_validators' => [
            \App\Models\Point::class => \App\Imports\Validators\PointValidator::class,
        ],

        'models_services' => [
            \App\Models\Point::class => \App\Services\PointService::class,
        ],

        'folders' => [
            'import_csv_files' => 'imports',
        ],

    ],

    'roles' => [
        'backend' => [
            1, // ADM
        ],
        'frontend' => [
            2, // USI
        ],
    ]


];
