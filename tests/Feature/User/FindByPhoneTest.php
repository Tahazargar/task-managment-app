<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can fetch a single user by phone', function (): void {
    $user = User::factory()->create();

    $response = $this->getJson(route('findByPhone', $user->phone));

    $response->assertStatus(200)
        ->assertJsonPath('data.phone', $user->phone)
        ->assertJsonPath('data.email', $user->email);
});

it('returns 404 if user not found by phone', function (): void {
    $response = $this->getJson(route('findByPhone', 'non-existent-phone-123'));

    $response->assertStatus(404);
});
