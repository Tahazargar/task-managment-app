<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


it('can soft delete a user', function (): void {
    $user = User::factory()->create();

    $response = $this->deleteJson(route('api.users.destroy', $user->uuid));

    $response->assertStatus(204);

    $this->assertSoftDeleted('users', [
        'id' => $user->id
    ]);
});
