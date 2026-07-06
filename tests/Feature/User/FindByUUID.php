<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can fetch a single user by uuid', function (): void {
    $user = User::factory()->create();

    $response = $this->getJson(route('api.users.show', $user->uuid));

    $response->assertStatus(200)
        ->assertJsonPath('data.uuid', $user->uuid)
        ->assertJsonPath('data.email', $user->email);
});

it('returns 404 if user not found by uuid', function (): void {
    $response = $this->getJson(route('api.users.show', 'non-existent-uuid-123'));

    $response->assertStatus(404);
});
