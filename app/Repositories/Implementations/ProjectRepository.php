<?php

declare(strict_types=1);

namespace App\Repositories\Implementations;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

readonly class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * Retrieve paginated projects with optional filters.
     */
    public function paginate(
        int $perPage = 15,
        array $filters = [],
        array $relations = []
    ): CursorPaginator {
        return Project::query()
            ->with($relations)
            ->when(
                isset($filters['owner_id']),
                fn (Builder $query) => $query->where('owner_id', $filters['owner_id'])
            )
            ->when(
                isset($filters['status']),
                fn (Builder $query) => $query->where('status', $filters['status'])
            )
            ->when(
                isset($filters['search']),
                fn (Builder $query) => $query->where(function (Builder $query) use ($filters): void {
                    $query
                        ->where('name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['search'] . '%');
                })
            )
            ->latest()
            ->cursorPaginate($perPage);
    }

    /**
     * Find a project by UUID.
     */
    public function findByUuid(
        string $uuid,
        array $relations = []
    ): ?Project {
        return Project::query()
            ->with($relations)
            ->where('uuid', $uuid)
            ->first();
    }

    /**
     * Retrieve multiple projects by IDs.
     *
     * @return Collection<int, Project>
     */
    public function findMany(
        array $ids,
        array $relations = []
    ): Collection {
        return Project::query()
            ->with($relations)
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * Create a new project.
     */
    public function store(array $data): Project
    {
        return Project::create($data);
    }

    /**
     * Update an existing project.
     */
    public function update(
        string $uuid,
        array $data
    ): Project {
        $project = Project::query()
            ->where('uuid', $uuid)
            ->firstOrFail();

        $project->update($data);

        return $project->fresh();
    }

    /**
     * Delete a project.
     */
    public function destroy(string $uuid): bool
    {
        return (bool) Project::query()
            ->where('uuid', $uuid)
            ->delete();
    }

    /**
     * Check whether a project exists.
     */
    public function exists(string $uuid): bool
    {
        return Project::query()
            ->where('uuid', $uuid)
            ->exists();
    }

    /**
     * Search projects by name or description.
     *
     * @return Collection<int, Project>
     */
    public function search(
        string $keyword,
        int $limit = 20
    ): Collection {
        return Project::query()
            ->where(function (Builder $query) use ($keyword): void {
                $query
                    ->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Count projects with optional filters.
     */
    public function count(array $filters = []): int
    {
        return Project::query()
            ->when(
                isset($filters['owner_id']),
                fn (Builder $query) => $query->where('owner_id', $filters['owner_id'])
            )
            ->when(
                isset($filters['status']),
                fn (Builder $query) => $query->where('status', $filters['status'])
            )
            ->count();
    }
}
