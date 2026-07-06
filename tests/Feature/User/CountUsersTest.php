<?php

declare(strict_types=1);

use App\Models\User;
use App\Repositories\Implementations\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can count all users when no filter is provided', function (): void {
    // Seed 3 users in the database
    User::factory()->count(3)->create();

    $repository = new UserRepository();

    /** @var int $count */
    $count = $repository->count();

    expect($count)->toBe(3);
});

it('can count users filtered by active status', function (): void {
    // Create 2 active and 1 inactive users
    User::factory()->count(2)->create(['is_active' => true]);
    User::factory()->create(['is_active' => false]);

    $repository = new UserRepository();

    // Verify active count
    /** @var int $activeCount */
    $activeCount = $repository->count(['is_active' => true]);
    expect($activeCount)->toBe(2);

    // Verify inactive count
    /** @var int $inactiveCount */
    $inactiveCount = $repository->count(['is_active' => false]);
    expect($inactiveCount)->toBe(1);
});
