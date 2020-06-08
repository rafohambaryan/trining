<?php


namespace App\Repository\Backend\Interfaces;


use App\Models\Film;

interface FilmRepositoryInterfaces
{
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function createOrUpdate($request, $id): Film;

    /**
     * @param $id
     * @return mixed
     */
    public function deleted($id);
}
