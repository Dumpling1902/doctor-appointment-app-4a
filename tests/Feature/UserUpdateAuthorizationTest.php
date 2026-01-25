<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Un usuario no autenticado no puede actualizar un usuario', function () {
    // 1) Crear usuario objetivo
    $user = User::factory()->create();

    // 2) Intentar actualizar SIN estar autenticado
    $response = $this->putJson(route('admin.users.update', $user), [
        'name' => 'Nombre Modificado',
    ]);

    // 3) Esperar no autorizado
    $response->assertStatus(401);

    // 4) Verificar que no se modifico en la BD
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $user->name,
    ]);
});

test('Un usuario autenticado puede actualizar un usuario', function () {
    // 1) Crear usuario autenticado
    $authUser = User::factory()->create();

    // 2) Crear usuario a modificar
    $user = User::factory()->create();

    // 3) Simular inicio de sesion
    $this->actingAs($authUser, 'web');

    // 4) Actualizar usuario con datos validos
    $response = $this->putJson(route('admin.users.update', $user), [
        'name' => 'Nombre Actualizado',
        'email' => 'nuevo' . rand(1, 1000) . '@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'id_number' => 'ID-' . rand(1000, 9999),
        'phone' => '1234567890',
        'address' => 'Direccion de prueba',
    ]);

    // 5) Esperar OK
    $response->assertStatus(200);

    // 6) Verificar cambio en BD
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Nombre Actualizado',
    ]);
});
