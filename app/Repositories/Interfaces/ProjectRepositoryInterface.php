<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Project;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    /**
     * Retrieve projects using cursor pagination with optional filters.
     */
    public function paginate(
        int $perPage = 15,
        array $filters = [],
        array $relations = []
    ): CursorPaginator;

    /**
     * Find a project by UUID.
     */
    public function findByUuid(
        string $uuid,
        array $relations = []
    ): ?Project;

    /**
     * Retrieve multiple projects by IDs.
     *
     * @return Collection<int, Project>
     */
    public function findMany(
        array $ids,
        array $relations = []
    ): Collection;

    /**
     * Create a new project.
     */
    public function store(array $data): Project;

    /**
     * Update an existing project.
     */
    public function update(
        string $uuid,
        array $data
    ): Project;

    /**
     * Delete a project.
     */
    public function destroy(string $uuid): bool;

    /**
     * Check whether a project exists.
     */
    public function exists(string $uuid): bool;

    /**
     * Search projects by name or description.
     *
     * @return Collection<int, Project>
     */
    public function search(
        string $keyword,
        int $limit = 20
    ): Collection;

    /**
     * Count projects with optional filters.
     */
    public function count(array $filters = []): int;
}
