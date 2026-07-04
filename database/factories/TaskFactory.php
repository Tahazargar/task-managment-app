<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+2 months'),
            'status_id' => TaskStatus::factory(),
            'parent_id' => null,
            'project_id' => Project::factory(),
            'type_id' => TaskType::factory(),
        ];
    }
}
