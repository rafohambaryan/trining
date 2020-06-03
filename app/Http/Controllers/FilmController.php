<?php

namespace App\Http\Controllers;

use App\Helpers\Hash;
use App\Models\Checked;
use App\Models\DateFilm;
use App\Models\Film;
use App\Models\Line;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $films = Film::all();
        $lines = Line::all();
        return view('films', compact('films', 'lines'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilm(Request $request)
    {
        $film_id = $request->input('film_id');
        $film = Film::find($film_id);
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
        $checked_lines = [];

        $date_id = $request->input('date_id');
        $date = DateFilm::find($date_id);
        $checked = Checked::where('film_id', $date->film->id)->where('date_film_id', $date_id)->get();
        $newArr = true;
        $last_id = 0;
        foreach ($checked as $item) {
            if ($item->count_line->line->id !== $last_id && !isset($checked_lines[$item->count_line->line->id])) {
                $checked_lines[$item->count_line->line->id] = [];
                $newArr = true;
            }
            if ($newArr) {
                $newArr = false;
                $last_id = $item->count_line->line->id;
            }
            array_push($checked_lines[$item->count_line->line->id], $item->count_line->id);
        }
        $lines = Line::all()->load('counter');
        return response()->json(['success' => true, 'lines' => $lines, 'checked' => $checked_lines]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checked(Request $request)
    {
        $film_id = $request->input('film');
        $date_film_id = $request->input('date');
        $count_line_id = $request->input('count');
        $checkedUnique = Checked::where('film_id', $film_id)->where('date_film_id', $date_film_id)->where('count_line_id', $count_line_id)->first();
        if (!$checkedUnique) {
            $checked = new Checked();
            $checked->film_id = $request->input('film');
            $checked->date_film_id = $request->input('date');
            $checked->count_line_id = $request->input('count');
            $checked->card = Hash::unique($checked, 'card', 5);
            $checked->save();
            return response()->json(['success' => true, 'card' => $checked->card], 201);
        }
        return response()->json(['success' => false]);
    }
}
