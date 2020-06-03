<?php


namespace App\Service\Backend;


use App\Models\Film;

class FilmService extends Film
{
    protected $table = 'films';

    public function getAll()
    {
        return $this->all();
    }

    public function firstOrNew($id, $user_id)
    {
        return parent::firstOrNew(['id' => $id, 'user_id' => $user_id]);
    }
}
