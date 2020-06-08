<?php


namespace App\Repository\Backend;


use App\Repository\Backend\Interfaces\UnitRepositoryInterfaces;
use App\Service\Backend\UnitService;

class UnitRepository implements UnitRepositoryInterfaces
{
    /**
     * @var UnitService
     */
    protected $service;

    /**
     * UnitRepository constructor.
     * @param UnitService $service
     */
    public function __construct(UnitService $service)
    {
        $this->service = $service;
    }

    /**
     * @return UnitService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->service->getAll();
    }

}
