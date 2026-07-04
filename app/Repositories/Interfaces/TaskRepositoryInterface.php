<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * Retrieve a paginated list of tasks using cursor pagination.
     */
    public function paginate(int $perPage = 15, array $filters = []): CursorPaginator;

    /**
     * Find a task by its unique identifier (e.g., UUID).
     */
    public function findByUuid(string $uuid, array $relations = []): ?Task;

    /**
     * Create a new task.
     */
    public function store(array $data): Task;

    /**
     * Update an existing task.
     */
    public function update(string $uuid, array $data): Task;

    /**
     * Delete a task.
     */
    public function destroy(string $uuid): bool;

    /**
     * Get tasks based on specific filters (e.g., status, user_id).
     */
    public function filter(array $filters): Collection;

    /**
     * Get the count of tasks for a specific user or status.
     */
    public function count(array $filters = []): int;
}
