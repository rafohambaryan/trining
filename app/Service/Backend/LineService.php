<?php


namespace App\Service\Backend;


use App\Models\Line;

class LineService extends Line
{
    protected $table = 'lines';

    /**
     * @return LineService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return parent::all();
    }
}
