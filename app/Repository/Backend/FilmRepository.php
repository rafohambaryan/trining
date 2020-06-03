<?php


namespace App\Repository\Backend;


use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use App\Service\Backend\FilmService;
use Illuminate\Support\Facades\Auth;

class FilmRepository implements FilmRepositoryInterfaces
{
    protected $service;

    public function __construct(FilmService $service)
    {
        $this->service = $service;
    }

    /**
     * @return FilmService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->service->getAll();
    }

    public function createOrUpdate($data, $id)
    {
        $name = $data['name'];
        $description = $data['description'];
        $film = $this->service->firstOrNew($id, Auth::id());
        $film->name = $name;
        $film->description = $description ? $description : ' ';
        $film->user_id = Auth::id();
        $film->save();
        $date = json_decode($data['date']);
        return true;
    }
}
