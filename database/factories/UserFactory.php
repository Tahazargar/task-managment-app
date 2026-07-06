<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('###########'),
            'role_id' => Role::factory(),
            'avatar' => fake()->imageUrl(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_active' => true,
        ];
    }
}
