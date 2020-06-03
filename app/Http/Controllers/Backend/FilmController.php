<?php

namespace App\Http\Controllers\Backend;

use App\Models\DateFilm;
use App\Models\Film;
use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{
    /**
     * @var FilmRepositoryInterfaces
     */
    protected $interfaces;

    /**
     * FilmController constructor.
     * @param FilmRepositoryInterfaces $interfaces
     */
    public function __construct(FilmRepositoryInterfaces $interfaces)
    {
        $this->middleware('auth');
        $this->interfaces = $interfaces;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function films()
    {
        return view('backend.films', ['films' => $this->interfaces->get()]);
    }


    public function createOrUpdate(Request $request, $id = 0)
    {

        $name = $request->input('name');
        $description = $request->input('description');
        $film = Film::firstOrNew(['id' => $id, 'user_id' => Auth::id()]);
        $film->name = $name;
        $film->description = $description ? $description : ' ';
        $film->user_id = Auth::id();
        $film->save();
        $date = json_decode($request->input('date'));
//        foreach (DateFilm::where('film_id', $id)->get() as $item) {
//            $item->delete();
//        }
        if (isset($date) && !empty($date)) {
            $dateOld = current(DateFilm::where('film_id', $id)->get());
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
//                dump($dateOld);
//                dump($date);
            }
        } else {
            foreach (DateFilm::where('film_id', $id)->get() as $item) {
                $item->delete();
            }
        }
        $film = $this->interfaces->createOrUpdate($request->all(), $id);
        $response['success'] = false;
        if ($film) {
            $response['success'] = true;
            $response['data'] = $film;
        }
        return response()->json($response, 201);
    }

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

}
