<?php


namespace App\Service\Backend;


use App\Models\Unit;

class UnitService extends Unit
{
    protected $table = 'units';

    /**
     * @return UnitService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return parent::all();
    }

}
