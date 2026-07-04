<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProjectUser;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectUserFactory extends Factory
{
    protected $model = ProjectUser::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
