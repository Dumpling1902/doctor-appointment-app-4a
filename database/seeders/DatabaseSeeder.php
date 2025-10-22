<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Llamar al RoleSeeder creado
        $this->call(RoleSeeder::class);
        // User::factory(10)->create();
        

        //Crear un usuario de prueba
        User::factory()->create([
            'name' => 'Pedro Perez',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
