<?php


namespace App\Service\Backend;


use App\Models\DateFilm;

class DateFilmService extends DateFilm
{

    protected $table = 'date_films';

    /**
     * @param $film_id
     * @return mixed
     */
    public static function getByFilmId($film_id)
    {
        return parent::where('film_id', $film_id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return parent::find($id);
    }

    public function searchDate($start, $end)
    {
        return parent::where('start_date', '>=', $start)->where('end_date', '<=', $end)->select(['film_id as id'])->get();
    }
}
