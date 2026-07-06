<?php


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can update user attributes', function (): void {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'is_active' => true
    ]);

    $payload = [
        'name' => 'New Updated Name',
        'is_active' => false
    ];

    $response = $this->putJson(route('api.users.update', $user->uuid), $payload);

    $response->assertStatus(200)
        ->assertJsonPath('data.name', 'New Updated Name')
        ->assertJsonPath('data.is_active', false);

    $this->assertDatabaseHas('users', [
        'uuid' => $user->uuid,
        'name' => 'New Updated Name',
        'is_active' => false
    ]);
});
