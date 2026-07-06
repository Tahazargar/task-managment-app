<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can restore a soft deleted user', function (): void {
    $user = User::factory()->create([
        'deleted_at' => now()
    ]);

    $response = $this->postJson(route('api.users.restore', $user->uuid));

    $response->assertStatus(200);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'deleted_at' => null
    ]);
});
