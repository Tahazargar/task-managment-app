<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectUser;

class ProjectUserSeeder extends Seeder
{
    public function run(): void
    {
        ProjectUser::factory()->count(50)->create();
    }
}
