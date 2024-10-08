<?php

namespace App\Models;

use App\Enums\RecipeDifficulty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'ingredients',
        'instructions',
        'prep_time',
        'difficulty',
        'user_id',
    ];

    protected $casts = [
        'difficulty' => RecipeDifficulty::class,
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
