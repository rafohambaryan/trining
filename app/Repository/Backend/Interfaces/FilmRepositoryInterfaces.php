<?php


namespace App\Repository\Backend\Interfaces;


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
     * @param $data
     * @param $id
     * @return mixed
     */
    public function createOrUpdate($data, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function deleted($id);
}
