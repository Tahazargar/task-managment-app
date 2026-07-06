<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class UserController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function index(Request $request): ResourceCollection
    {
        $users = $this->userRepository->paginate(
            perPage: (int) $request->query('perPage', 15),
            filters: $request->only(['search', 'is_active'])
        );

        return UserResource::collection($users);
    }

    public function show(string $uuid): UserResource
    {
        $user = $this->userRepository->findByUuid($uuid);

        abort_if(!$user, 404);

        return new UserResource($user);
    }

    public function findByEmail(string $email): UserResource
    {
        $user = $this->userRepository->findByEmail($email);

        abort_if(!$user, 404);

        return new UserResource($user);
    }

    public function findByPhone(string $phone): UserResource
    {
        $user = $this->userRepository->findByPhone($phone);

        abort_if(!$user, 404);

        return new UserResource($user);
    }

    public function search(Request $request): ResourceCollection
    {
        $users = $this->userRepository->search(
            keyword: (string) $request->query('keyword'),
            limit: (int) $request->query('limit', 20)
        );

        return UserResource::collection($users);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $user = $this->userRepository->store($request->validated());

        return new UserResource($user);
    }

    public function update(string $uuid, UserUpdateRequest $request): UserResource
    {
        $user = $this->userRepository->update($uuid, $request->validated());

        return new UserResource($user);
    }

    public function destroy(string $uuid): JsonResponse
    {
        $this->userRepository->destroy($uuid);

        return response()->json(['message' => 'User deleted'], 204);
    }

    public function restore(string $uuid): JsonResponse
    {
        $this->userRepository->restore($uuid);

        return response()->json(['message' => 'User restored']);
    }

    public function forceDelete(string $uuid): JsonResponse
    {
        $this->userRepository->forceDelete($uuid);

        return response()->json(['message' => 'User permanently deleted'], 204);
    }

    public function stats(Request $request): JsonResponse
    {
        $count = $this->userRepository->count(
            $request->only(['is_active'])
        );

        return response()->json([
            'count' => $count
        ]);
    }

    public function exists(string $uuid): JsonResponse
    {
        return response()->json([
            'exists' => $this->userRepository->exists($uuid)
        ]);
    }
}
