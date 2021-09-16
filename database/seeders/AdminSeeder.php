<?php

namespace Database\Seeders;
Use App\Models\User;
Use App\Models\Sector;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Sector::create([
            'nome_sector' => 'Departamento de Recursos Digitais',
            'edificio' => 'Sede',
        ]);

        User::create([
            'name' => 'Dilson Andre Augusto Sevene',
            'email' => 'dilson.a.a.sevene@gmail.com',
            'password' => bcrypt('11111111'),
            'role' => 'administrator',
            'sector_id' => '6'
        ]);
    }
}
