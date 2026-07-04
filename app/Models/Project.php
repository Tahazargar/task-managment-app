<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'owner_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'owner_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public static function boot()
    {
        static::creating(fn ($model) => $model->uuid = (string) Str::uuid());
    }
}
