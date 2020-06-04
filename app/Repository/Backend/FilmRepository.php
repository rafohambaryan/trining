<?php


namespace App\Repository\Backend;


use App\Models\DateFilm;
use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use App\Service\Backend\DateFilmService;
use App\Service\Backend\FilmService;
use Illuminate\Support\Facades\Auth;

class FilmRepository implements FilmRepositoryInterfaces
{
    /**
     * @var FilmService
     */
    protected $service;

    /**
     * FilmRepository constructor.
     * @param FilmService $service
     */
    public function __construct(FilmService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $id
     */
    public function find($id)
    {
        return $this->service->find($id);
    }

    /**
     * @return FilmService[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        return $this->service->getAll();
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
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
        if (isset($date) && !empty($date)) {
            $dateOld = DateFilmService::getByFilmId($id);
            if (empty($dateOld)) {
                foreach ($date as $index => $item) {
                    $dates = explode(' - ', $item);
                    $this->addDate($dates[0], $dates[1], new DateFilm(), $index, $film->id);
                }
            } else {
                foreach ($dateOld as $i => $old) {
                    if (isset($date[$i])) {
                        $dates = explode(' - ', $date[$i]);
                        $this->addDate($dates[0], $dates[1], $old);
                    } else {
                        $old->delete();
                    }
                }
                foreach ($date as $m => $key) {
                    if (!isset($dateOld[$m])) {
                        $dates = explode(' - ', $key);
                        $this->addDate($dates[0], $dates[1], new DateFilm(), $m, $film->id);
                    }
                }
            }
        } else {
            foreach (DateFilmService::getByFilmId($id) as $item) {
                $item->delete();
            }
        }

        return $film;
    }

    /**
     * @param $start
     * @param $end
     * @param $model
     * @param null $i
     * @param null $film_id
     * @return mixed
     */
    private function addDate($start, $end, $model, $i = null, $film_id = null)
    {
        $model->start_date = $start;
        $model->end_date = $end;
        if ($i !== null) {
            $model->order = $i;
        }
        if ($film_id !== null) {
            $model->film_id = $film_id;
        }
        return $model->save();

    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function deleted($id)
    {
        $film = $this->service->find($id);
        return ['success' => $film->delete()];
    }
}
