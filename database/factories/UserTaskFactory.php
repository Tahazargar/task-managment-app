<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTaskFactory extends Factory
{
    protected $model = UserTask::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
        ];
    }
}
