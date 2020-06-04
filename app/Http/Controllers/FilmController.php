<?php

namespace App\Http\Controllers;

use App\Helpers\Hash;
use App\Models\Checked;
use App\Models\DateFilm;
use App\Models\Film;
use App\Models\Line;
use App\Repository\Backend\Interfaces\CheckedRepositoryInterfaces;
use App\Repository\Backend\Interfaces\DateFilmRepositoryInterfaces;
use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use App\Repository\Backend\Interfaces\LineRepositoryInterfaces;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * @var FilmRepositoryInterfaces
     */
    protected $film;
    /**
     * @var LineRepositoryInterfaces
     */
    protected $line;
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
     * @param FilmRepositoryInterfaces $film
     * @param LineRepositoryInterfaces $line
     * @param DateFilmRepositoryInterfaces $dateFilm
     * @param CheckedRepositoryInterfaces $checked
     */
    public function __construct(FilmRepositoryInterfaces $film,
                                LineRepositoryInterfaces $line,
                                DateFilmRepositoryInterfaces $dateFilm,
                                CheckedRepositoryInterfaces $checked)
    {
        $this->film = $film;
        $this->line = $line;
        $this->dateFilm = $dateFilm;
        $this->checked = $checked;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $films = $this->film->get();
        $lines = $this->line->get();
        return view('films', compact('films', 'lines'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilm(Request $request)
    {
        $film_id = $request->input('film_id');
        $film = $this->film->find($film_id);
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
        $lines = $this->line->get()->load('counter');
        return response()->json(['success' => true, 'lines' => $lines, 'checked' => $this->dateFilm->getFilmData($date_id)]);
    }
}
