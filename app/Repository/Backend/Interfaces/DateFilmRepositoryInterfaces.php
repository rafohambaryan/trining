<?php


namespace App\Repository\Backend\Interfaces;


interface DateFilmRepositoryInterfaces
{
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $date_id
     * @return mixed
     */
    public function getFilmData($date_id);
}
