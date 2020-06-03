<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
      'user_id', 'name', 'description',
    ];

    public function getDate()
    {
        return $this->hasMany(DateFilm::class, 'film_id', 'id');
    }
}
