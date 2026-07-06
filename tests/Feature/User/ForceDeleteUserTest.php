<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can force delete a user', function (): void {
    $user = User::factory()->create([
        'deleted_at' => now()
    ]);

    $response = $this->deleteJson(route('api.users.forceDelete', $user->uuid));

    $response->assertStatus(204);

    $this->assertDatabaseMissing('users', [
        'id' => $user->id
    ]);
});
