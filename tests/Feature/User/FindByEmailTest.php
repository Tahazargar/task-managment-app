<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can fetch a single user by email', function (): void {
    $user = User::factory()->create();

    $response = $this->getJson(route('findByEmail', $user->email));

    $response->assertStatus(200)
        ->assertJsonPath('data.email', $user->email)
        ->assertJsonPath('data.phone', $user->phone);
});

it('returns 404 if user not found by email', function (): void {
    $response = $this->getJson(route('findByEmail', 'nonExistent-email-123'));

    $response->assertStatus(404);
});
