<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can search users by name', function () {
    User::factory()->create(['name' => 'John Doe']);
    User::factory()->create(['name' => 'Jane Doe']);
    User::factory()->create(['name' => 'John Smith']);

    $response = $this->getJson(route('users.search', ['keyword' => 'John']));

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                    'email',
                    'phone',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
});

it('can search users by email', function () {
    User::factory()->create(['email' => 'exampleTaha@gmail.com']);
    User::factory()->create(['email' => 'exampleTaha1@gmail.com']);
    User::factory()->create(['email' => 'test@gmail.com']);

    $response = $this->getJson(route('users.search', ['keyword' => 'example']));

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                    'email',
                    'phone',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
});

it('can search users by combination of email and name', function () {
    User::factory()->create(['name' => 'John Doe']);
    User::factory()->create(['email' => 'JohnDis@gmail.com']);
    User::factory()->create(['name' => 'Jane Doe']);

    $response = $this->getJson(route('users.search', ['keyword' => 'John']));

    $response->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'uuid',
                    'name',
                    'email',
                    'phone',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
});
