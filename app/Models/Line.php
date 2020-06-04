<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = [
        'name','order'
    ];
    public function counter()
    {
        return $this->hasMany(CountLine::class, 'line_id', 'id');
    }
}
