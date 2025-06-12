<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;

    protected $primaryKey = 'cast_id';
    protected $fillable = [
        'cast_full_name',
        'cast_first_name',
        'cast_last_name',
        'cast_gender',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'cast_members', 'cast_id', 'movie_id');
    }
}