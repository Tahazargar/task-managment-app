<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Retrieve users with cursor pagination.
     */
    public function paginate(
        int $perPage = 15,
        array $filters = [],
        array $relations = []
    ): CursorPaginator;

    /**
     * Find a user by UUID.
     */
    public function findByUuid(
        string $uuid,
        array $relations = []
    ): ?User;

    /**
     * Find a user by email address.
     */
    public function findByEmail(
        string $email,
        array $relations = []
    ): ?User;

    /**
     * Find a user by phone number.
     */
    public function findByPhone(
        string $phone,
        array $relations = []
    ): ?User;

    /**
     * Retrieve multiple users by IDs.
     *
     * @return Collection<int, User>
     */
    public function findMany(
        array $ids,
        array $relations = []
    ): Collection;

    /**
     * Create a new user.
     */
    public function store(array $data): User;

    /**
     * Update an existing user.
     */
    public function update(
        string $uuid,
        array $data
    ): User;

    /**
     * Soft delete a user.
     */
    public function destroy(string $uuid): bool;

    /**
     * Restore a soft deleted user.
     */
    public function restore(string $uuid): bool;

    /**
     * Permanently delete a user.
     */
    public function forceDelete(string $uuid): bool;

    /**
     * Check whether a user exists by UUID.
     */
    public function exists(string $uuid): bool;

    /**
     * Search users by name or email.
     *
     * @return Collection<int, User>
     */
    public function search(
        string $keyword,
        int $limit = 20
    ): Collection;

    /**
     * Count users with optional filters.
     */
    public function count(array $filters = []): int;
}
