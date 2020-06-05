<?php


namespace App\Service\Backend;


use App\Models\Genre;

class GenreService extends Genre
{
    /**
     * @var string
     */
    protected $table = 'genres';

    /**
     * @return GenreService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return parent::all();
    }

}
