<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $start = $this->faker->optional()->dateTimeBetween('-1 year', 'now');
        $end = $start ? $this->faker->optional()->dateTimeBetween($start, '+1 year') : null;

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'owner_id' => User::factory(),
            'start_date' => $start,
            'end_date' => $end,
        ];
    }
}
