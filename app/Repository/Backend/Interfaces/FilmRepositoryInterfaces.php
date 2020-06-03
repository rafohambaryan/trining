<?php


namespace App\Repository\Backend\Interfaces;


interface FilmRepositoryInterfaces
{
    /**
     * @return mixed
     */
    public function get();

    public function createOrUpdate($data, $id);
}
