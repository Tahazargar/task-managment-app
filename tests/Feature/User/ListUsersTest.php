<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a list of users with status code 200', function (): void {
    User::factory()->count(10)->create();

    $response = $this->get('/api/users');

    $response->assertStatus(200)
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
            ],
            'links',
            'meta',
        ]);

    $response->assertJsonCount(10, 'data');
});

it('respects the perPage query parameter', function (): void {
    User::factory()->count(45)->create();

    $response = $this->getJson('/api/users?perPage=15');

    $response->assertStatus(200)
        ->assertJsonCount(15, 'data')
        ->assertJsonPath('meta.per_page', 15)
        ->assertJsonStructure(
            [
                'data',
                'meta' => ['path', 'per_page', 'next_cursor', 'prev_cursor']
            ]
        );
});

it('filter users by search term matching name', function (): void {
    User::factory()->create(['name' => 'Alice Johnson', 'email' => 'alice@test.com']);
    User::factory()->create(['name' => 'Bob Smith', 'email' => 'bob@test.com']);

    $response = $this->getJson('/api/users?search=Alice');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.name', 'Alice Johnson');
});

it('filter users by search term matching email', function (): void {
    User::factory()->create(['name' => 'Alice Johnson', 'email' => 'alice@test.com']);
    User::factory()->create(['name' => 'Bob Smith', 'email' => 'bob@test.com']);

    $response = $this->getJson('/api/users?search=Bob');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.email', 'bob@test.com');
});

it('filter users by status is_active', function (): void {
    User::factory()->count(3)->create(['is_active' => true]);
    User::factory()->count(2)->create(['is_active' => false]);

    $response = $this->getJson('/api/users?is_active=1');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('filter users by search and is_active', function (): void {
    User::factory()->create(['name' => 'ali active', 'is_active' => true]);
    User::factory()->create(['name' => 'ali not active', 'is_active' => false]);

    $response = $this->getJson('/api/users?search=ali&is_active=1');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.name', 'ali active');
});

it('returns nothing when search term not exists', function (): void {
    User::factory()->count(10)->create();

    $response = $this->getJson('/api/users?search=NotExistentUser');

    $response->assertStatus(200)
        ->assertJsonCount(0, 'data');
});

it('treats string "false" correctly for is_active filter', function (): void {
    User::factory()->create(['is_active' => false]);
    User::factory()->count(3)->create(['is_active' => true]);

    $response = $this->getJson('/api/users?is_active=false');

    $response->assertJsonCount(1, 'data');
});
