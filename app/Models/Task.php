<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status_id',
        'parent_id',
        'project_id',
        'type_id',
    ];

    protected $casts = [
        'due_date' => 'date',
        'status_id' => 'integer',
        'parent_id' => 'integer',
        'project_id' => 'integer',
        'type_id' => 'integer',
    ];

    public static function boot()
    {
        static::creating(fn ($model) => $model->uuid = (string) Str::uuid());
    }
}
