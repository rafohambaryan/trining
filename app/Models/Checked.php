<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checked extends Model
{
    protected $fillable = [
        'film_id', 'date_film_id', 'count_line_id', 'card'
    ];

    public function count_line()
    {
        return $this->belongsTo(CountLine::class, 'count_line_id', 'id');
    }

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id', 'id');
    }

    public function date()
    {
        return $this->belongsTo(DateFilm::class, 'date_film_id', 'id');
    }
}
