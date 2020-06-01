<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function getDate()
    {
        return $this->hasMany(DateFilm::class,'film_id','id');
    }
}
