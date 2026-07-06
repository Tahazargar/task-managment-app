<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can store a new user', function (): void {
    $payload = [
        'name' => 'Taha Dev',
        'email' => 'taha@example.com',
        'phone' => '+989123456789',
        'is_active' => true,
        'password' => 'secret-password'
    ];

    $response = $this->postJson(route('api.users.store'), $payload);

    $response->assertStatus(201)
        ->assertJsonPath('data.email', $payload['email']);

    $this->assertDatabaseHas('users', [
        'email' => $payload['email'],
        'phone' => $payload['phone']
    ]);
});
