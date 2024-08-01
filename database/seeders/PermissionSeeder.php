<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    protected $permissions = [
        'points' => [
            [
                'name'=> 'points.show',
                'title' => 'Ver punto',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.list',
                'title' => 'Consulta de Puntos',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.edit',
                'title' => 'Modificar de Punto',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.create',
                'title' => 'Crear punto',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.destroy',
                'title' => 'Eliminar Punto',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.import',
                'title' => 'Importar',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.report',
                'title' => 'Denunciar',
                'roles' => ['ADM', 'USI'],
            ],
            [
                'name'=> 'points.approve',
                'title' => 'Aprobar o Rechazar Punto',
                'roles' => ['ADM'],
            ],
        ],

        'users' => [
            [
                'name'=> 'users.list',
                'title' => 'Consultar Usuarios',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.create',
                'title' => 'Crear Usuario',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.edit',
                'title' => 'Modificar Usuario',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.blockEnable',
                'title' => 'Bloquear/Habilitar Usuario',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.requestsList',
                'title' => 'Bandeja de Solicitudes Pendientes',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.rejectRequest',
                'title' => 'Rechazar Solicitud',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.acceptRequest',
                'title' => 'Aceptar Solicitud',
                'roles' => ['ADM'],
            ],
            [
                'name'=> 'users.rejectedList',
                'title' => 'Bandeja de Solicitudes Rechazadas',
                'roles' => ['ADM'],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->permissions)->each(function ($abilities, $group) {
            foreach ($abilities as $ability) {
                $permission = Permission::forceCreate(
                    Arr::except($ability, ['roles'])
                );

                foreach ($ability['roles'] as $rol) {
                    Role::findByName($rol)->givePermissionTo($permission);
                }
            }
        });
    }
}
