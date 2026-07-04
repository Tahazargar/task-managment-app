<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class UserTask extends Model
{
    use HasFactory;
    use HasApiTokens;

    public $timestamps = false;

    protected $table = 'user_task';

    protected $fillable = [
        'user_id',
        'task_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'task_id' => 'integer',
    ];
}
