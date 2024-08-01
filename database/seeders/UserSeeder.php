<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class  UserSeeder extends Seeder
{
    protected $data = [
        [
            'name' => 'Ada Lovelance',
            'email' => 'admin@test.test',
            'document_number' => '123456789',
            'institution' => 'Universidade de São Paulo',
            'role' => 'ADM',
        ],
        [
            'name' => 'Nicola Tesla',
            'email' => 'user@test.test',
            'document_number' => '987654321',
            'institution' => 'Universidad de Salta',
            'role' => 'USI',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $data) {
            $data['password'] = bcrypt('secret');
            $data['requested_at'] = today();
            $data['approved_at'] = today();
            User::create(Arr::except($data,'role'))
                ->assignRole($data['role']);
        }
    }
}
