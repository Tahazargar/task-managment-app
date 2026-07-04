<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class TaskStatus extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'title',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
