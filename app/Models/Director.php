<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $primaryKey = 'director_id';
    protected $fillable = [
        'director_full_name',
        'director_first_name',
        'director_last_name',
        'director_gender',
    ];

    public function movies()
    {
        return $this->hasMany(Movie::class, 'director_id', 'director_id');
    }
}