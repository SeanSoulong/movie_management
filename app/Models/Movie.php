<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Director; // Add this if not already present
use App\Models\Genre;    // Add this if not already present
use App\Models\Cast;     // Add this if not already present

class Movie extends Model
{
    use HasFactory;

    protected $primaryKey = 'movie_id';
    protected $fillable = [
        'movie_title',
        'movie_description',
        'movie_release_date',
        'movie_duration',
        'director_id',
    ];

    public function director()
    {
        return $this->belongsTo(Director::class, 'director_id', 'director_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
    }

    /**
     * RENAMED: Use castMembers() to avoid conflict with Laravel's $casts property.
     */
    public function castMembers() // <--- Renamed this method
    {
        return $this->belongsToMany(Cast::class, 'cast_members', 'movie_id', 'cast_id');
    }
}