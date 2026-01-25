<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('No se puede crear un usuario con datos invalidos', function () {
    // 1) Crear usuario autenticado
    $user = User::factory()->create();

    // 2) Simular login
    $this->actingAs($user, 'web');

    // 3) Enviar datos invalidos (JSON)
    $response = $this->postJson(route('admin.users.store'), [
        'name' => '',
        'email' => 'correo-no-valido',
        'password' => '',
        'password_confirmation' => '',
        'id_number' => '',
        'phone' => '',
        'address' => '',
        'role_id' => '',
    ]);

    // 4) Esperar error de validacion
    $response->assertStatus(422);

    // 5) Verificar que NO se creo el usuario
    $this->assertDatabaseCount('users', 1);
});
