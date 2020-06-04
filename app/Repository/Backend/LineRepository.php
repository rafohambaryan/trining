<?php


namespace App\Repository\Backend;


use App\Repository\Backend\Interfaces\LineRepositoryInterfaces;
use App\Service\Backend\LineService;

class LineRepository implements LineRepositoryInterfaces
{
    /**
     * @var LineService
     */
    protected $service;

    /**
     * LineRepository constructor.
     * @param LineService $service
     */
    public function __construct(LineService $service)
    {
        $this->service = $service;
    }

    /**
     * @return LineService[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function get()
    {
        return $this->service->get();
    }
}
