<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checked extends Model
{
    public function count_line()
    {
        return $this->belongsTo(CountLine::class, 'count_line_id', 'id');
    }
}
