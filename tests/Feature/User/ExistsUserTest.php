<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('should return existent user with status code 200', function () {
    $user = User::factory()->create([
        'name' => 'ali2000',
        'email' => 'ali@gmail.com',
        'uuid' => (string) Str::uuid()
    ]);

    $response = $this->getJson(route('api.users.exists', $user->uuid));

    $response->assertStatus(200)
        ->assertJsonPath('exists.data.exists', true)
        ->assertJsonStructure([
            'exists' => [
                'data' => [
                    'uuid',
                    'message',
                    'exists',
                ]
            ]
        ]);
});

it('should return exists false with status code 404', function () {
    $user = User::factory()->create([
        'name' => 'ali2000',
        'email' => 'ali@gmail.com',
        'uuid' => (string) Str::uuid()
    ]);

    $response = $this->getJson(route('api.users.exists', 'not-existing-uuid'));

    $response->assertStatus(200)
        ->assertJsonPath('exists.data.exists', false)
        ->assertJsonStructure([
            'exists' => [
                'data' => [
                    'message',
                    'exists',
                ]
            ]
        ]);
});
