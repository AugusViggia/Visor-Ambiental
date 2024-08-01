<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    protected $data = [
        [
            'name' => 'ADM',
            'title' => "Administrador"
        ],
        [
            'name' => 'USI',
            'title' => 'Usuario de Sistema',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $data) {
            Role::create($data);
        }
    }
}
