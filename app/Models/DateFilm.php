<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateFilm extends Model
{
    protected $fillable = [
        'film_id', 'start_date', 'end_date', 'order'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function checked()
    {
        return $this->hasMany(Checked::class, 'date_film_id', 'id');
    }
}
