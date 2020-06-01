<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountLine extends Model
{
    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id', 'id');
    }
}
