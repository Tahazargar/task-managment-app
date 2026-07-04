<?php

declare(strict_types=1);

namespace App\Repositories\Implementations;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

readonly class TaskRepository implements TaskRepositoryInterface
{
    /**
     * Retrieve a paginated list of tasks using cursor pagination.
     * Ideal for large datasets to prevent offset issues.
     */
    public function paginate(int $perPage = 15, array $filters = []): CursorPaginator
    {
        return Task::query()
            ->when(isset($filters['status']), fn(Builder $query) => $query->where('status', $filters['status']))
            ->when(isset($filters['user_id']), fn(Builder $query) => $query->where('user_id', $filters['user_id']))
            ->latest()
            ->cursorPaginate($perPage);
    }

    /**
     * Find a task by its unique identifier.
     * Eager loading is supported to avoid N+1 issues in API responses.
     */
    public function findByUuid(string $uuid, array $relations = []): ?Task
    {
        return Task::query()
            ->with($relations)
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * Create a new task.
     */
    public function store(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Update an existing task.
     * Uses firstOrFail internally via the controller or service if strictness is needed.
     */
    public function update(string $uuid, array $data): Task
    {
        $task = Task::where('uuid', $uuid)->firstOrFail();
        $task->update($data);
        return $task->fresh();
    }

    /**
     * Delete a task.
     */
    public function destroy(string $uuid): bool
    {
        return (bool) Task::where('uuid', $uuid)->delete();
    }

    /**
     * Filter tasks without pagination (e.g., for simple status lists).
     */
    public function filter(array $filters): Collection
    {
        return Task::query()
            ->when(isset($filters['priority']), fn(Builder $query) => $query->where('priority', $filters['priority']))
            ->get();
    }

    /**
     * Count tasks based on filter criteria.
     */
    public function count(array $filters = []): int
    {
        return Task::query()
            ->when(isset($filters['status']), fn(Builder $query) => $query->where('status', $filters['status']))
            ->count();
    }
}
