<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
            'name' => 'Damaris Ramirez',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
