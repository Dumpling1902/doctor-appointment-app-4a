<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('No se puede actualizar un usuario con datos invalidos', function () {
    // 1) Usuario autenticado
    $authUser = User::factory()->create();

    // 2) Usuario a modificar
    $user = User::factory()->create([
        'name' => 'Nombre Original',
    ]);

    $this->actingAs($authUser, 'web');

    // 3) Intentar actualizar con datos invalidos
    $response = $this->put(route('admin.users.update', $user), [
        'name' => '', // invalido
        'email' => 'correo-no-valido',
    ]);

    // 4) Esperar error de validacion
    $response->assertStatus(302);

    // 5) Verificar que NO se modifico en la BD
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Nombre Original',
    ]);
});
