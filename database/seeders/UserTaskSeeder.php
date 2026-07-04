<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserTask;

class UserTaskSeeder extends Seeder
{
    public function run(): void
    {
        UserTask::factory()->count(50)->create();
    }
}
