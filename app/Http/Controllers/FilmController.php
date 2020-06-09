<?php

namespace App\Http\Controllers;

use App\Events\FilmEvent;
use App\Events\LineEvent;
use App\Repository\Backend\Interfaces\CheckedRepositoryInterfaces;
use App\Repository\Backend\Interfaces\DateFilmRepositoryInterfaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class FilmController extends Controller
{
    /**
     * @var DateFilmRepositoryInterfaces
     */
    protected $dateFilm;
    /**
     * @var CheckedRepositoryInterfaces
     */
    protected $checked;

    /**
     * FilmController constructor.
     * @param DateFilmRepositoryInterfaces $dateFilm
     * @param CheckedRepositoryInterfaces $checked
     */
    public function __construct(DateFilmRepositoryInterfaces $dateFilm,
                                CheckedRepositoryInterfaces $checked)
    {
        $this->dateFilm = $dateFilm;
        $this->checked = $checked;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $films = Event::dispatch(new FilmEvent('get'), true, true);
        $lines = Event::dispatch(new LineEvent('get'), true, true);
        return view('films', ['films' => $films, 'lines' => $lines]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilm(Request $request)
    {
        $film_id = $request->input('film_id');
        $film = Event::dispatch(new FilmEvent('find', $film_id), true, true);

        if ($film) {
            $film_date = [];
            foreach ($film->getDate as $index => $item) {
                array_push($film_date, ['id' => $item->id, 'start_date' => $item->start_date, 'end_date' => $item->end_date]);
            }
            if (empty($film_date)) {
                goto end;
            }
            return response()->json(['success' => true, 'data' => $film_date]);
        }
        end:
        return response()->json(['success' => false, 'messages' => ['porceq mi poqr ush']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilmDate(Request $request)
    {
        $date_id = $request->input('date_id');
        $lines = Event::dispatch(new LineEvent('get'), true, true)->load('counter');

        return response()->json(['success' => true, 'lines' => $lines, 'checked' => $this->dateFilm->getFilmData($date_id)]);
    }
}
