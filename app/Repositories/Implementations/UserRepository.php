<?php

declare(strict_types=1);

namespace App\Repositories\Implementations;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

readonly class UserRepository implements UserRepositoryInterface
{
    /**
     * Retrieve paginated users with optional filters and eager loading.
     */
    public function paginate(
        int $perPage = 15,
        array $filters = [],
        array $relations = []
    ): CursorPaginator {
        return User::query()
            ->with($relations)
            ->when(
                isset($filters['search']),
                fn (Builder $query) => $query->where(function (Builder $query) use ($filters): void {
                    $query
                        ->where('name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('email', 'like', '%' . $filters['search'] . '%');
                })
            )
            ->when(
                isset($filters['is_active']),
                fn (Builder $query) => $query->where('is_active', (bool) $filters['is_active'])
            )
            ->latest()
            ->cursorPaginate($perPage);
    }

    /**
     * Find a user by UUID.
     */
    public function findByUuid(
        string $uuid,
        array $relations = []
    ): ?User {
        return User::query()
            ->with($relations)
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * Find a user by email.
     */
    public function findByEmail(
        string $email,
        array $relations = []
    ): ?User {
        return User::query()
            ->with($relations)
            ->where('email', $email)
            ->first();
    }

    /**
     * Find a user by phone.
     */
    public function findByPhone(
        string $phone,
        array $relations = []
    ): ?User {
        return User::query()
            ->with($relations)
            ->where('phone', $phone)
            ->first();
    }

    /**
     * Retrieve multiple users by IDs.
     *
     * @return Collection<int, User>
     */
    public function findMany(
        array $ids,
        array $relations = []
    ): Collection {
        return User::query()
            ->with($relations)
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * Create a new user.
     */
    public function store(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update an existing user.
     */
    public function update(
        string $uuid,
        array $data
    ): User {
        $user = User::query()
            ->where('uuid', $uuid)
            ->firstOrFail();

        $user->update($data);

        return $user->fresh();
    }

    /**
     * Soft delete a user.
     */
    public function destroy(string $uuid): bool
    {
        return (bool) User::query()
            ->where('uuid', $uuid)
            ->delete();
    }

    /**
     * Restore a soft deleted user.
     */
    public function restore(string $uuid): bool
    {
        return (bool) User::query()
            ->onlyTrashed()
            ->where('uuid', $uuid)
            ->restore();
    }

    /**
     * Permanently delete a user.
     */
    public function forceDelete(string $uuid): bool
    {
        return (bool) User::query()
            ->onlyTrashed()
            ->where('uuid', $uuid)
            ->forceDelete();
    }

    /**
     * Check whether a user exists.
     */
    public function exists(string $uuid): bool
    {
        return User::query()
            ->where('uuid', $uuid)
            ->exists();
    }

    /**
     * Search users by name or email.
     *
     * @return Collection<int, User>
     */
    public function search(
        string $keyword,
        int $limit = 20
    ): Collection {
        return User::query()
            ->where(function (Builder $query) use ($keyword): void {
                $query
                    ->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Count users with optional filters.
     */
    public function count(array $filters = []): int
    {
        return User::query()
            ->when(
                isset($filters['is_active']),
                fn (Builder $query) => $query->where('is_active', (bool) $filters['is_active'])
            )
            ->count();
    }
}
