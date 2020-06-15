<?php


namespace App\Repository\Backend;


use App\Helpers\Hash;
use App\Models\DateFilm;
use App\Models\Film;
use App\Models\GenreFilm;
use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use App\Service\Backend\DateFilmService;
use App\Service\Backend\FilmService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
    public function getAuth()
    {
        return $this->service->getAuth();
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function createOrUpdate($request, $id): Film
    {
        $data = $request->all();
        $name = $data['name'];
        $price = $data['price'];
        $unit_id = $data['unit'];
        $description = $data['description'];
        $film = $this->service->firstOrNew($id, Auth::id());
        if ($request->has('isFile') && $request->input('isFile') === '0') {
            goto deleteImg;
        }
        if ($request->has('isFile') && $request->input('isFile') === '1' && $request->has('file')) {
            $file = $request->file('file');
            $path_image = Hash::unique($film, 'image') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("/images/uploads/"), $path_image);
            deleteImg:
            if ($film->exists) {
                if (file_exists(public_path("images\uploads\\$film->image"))) {
                    File::delete(public_path("images\uploads\\$film->image"));
                }
            }
            $film->image = $path_image ?? null;
        }
        $film->price = $price ?? 0;
        $film->unit_id = $unit_id ?? 1;
        $film->name = $name;
        $film->description = $description ? $description : ' ';
        $film->user_id = Auth::id();
        $film->save();
        $genre = $data['genre'] ?? [];
        GenreFilm::where('film_id', $film->id)->delete();
        foreach ($genre as $i) {
            $genres = new GenreFilm();
            $genres->film_id = $film->id;
            $genres->genre_id = $i;
            $genres->save();
        }


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
        if ($film->exists) {
            if (file_exists(public_path("images\uploads\\$film->image"))) {
                File::delete(public_path("images\uploads\\$film->image"));
            }
        }
        return ['success' => $film->delete()];
    }
}
