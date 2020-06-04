<?php


namespace App\Repository\Backend\Interfaces;


interface CheckedRepositoryInterfaces
{
    /**
     * @param $data
     * @return mixed
     */
    public function checked($data);

    /**
     * @param $data
     * @return mixed
     */
    public function getOneChecked($data);

    /**
     * @param $code
     * @return mixed
     */
    public function getCode($code);
}
