<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenreFilm extends Model
{
    protected $fillable = [
        'genre_id', 'film_id'
    ];
    protected $hidden = [
        'film_id'
    ];
    public $timestamps = false;
}
