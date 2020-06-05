<?php


namespace App\Repository\Backend;


use App\Repository\Backend\Interfaces\GenreRepositoryInterfaces;
use App\Service\Backend\GenreService;

class GenreRepository implements GenreRepositoryInterfaces
{
    /**
     * @var GenreService
     */
    protected $service;

    /**
     * GenreRepository constructor.
     * @param GenreService $service
     */
    public function __construct(GenreService $service)
    {
        $this->service = $service;
    }

    public function get()
    {
        return $this->service->all();
    }
}
