<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateFilm extends Model
{
    public function film(){
        return $this->belongsTo(Film::class,'film_id','id');
    }
}
