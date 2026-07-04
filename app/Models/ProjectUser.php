<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class ProjectUser extends Model
{
    use HasFactory;
    use HasApiTokens;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'project_id',
        'created_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'project_id' => 'integer',
        'created_at' => 'datetime',
    ];
}
