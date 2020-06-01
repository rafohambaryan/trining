<?php

namespace App\Http\Controllers;

use App\Models\Checked;
use App\Models\CountLine;
use App\Models\DateFilm;
use App\Models\Film;
use App\Models\Line;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();
        return view('films', compact('films'));
    }

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


    public function getFilmDate(Request $request)
    {
        $checked_lines = [];

        $date_id = $request->input('date_id');
        $date = DateFilm::find($date_id);
        $checked = Checked::where('film_id', $date->film->id)->where('date_film_id', $date_id)->get();
        $newArr = true;
        $last_id = 0;
        foreach ($checked as $item) {
            if ($item->count_line->line->id !== $last_id) {
                $newArr = true;
            }
            if ($newArr) {
                $checked_lines[$item->count_line->line->id] = [];
                $newArr = false;
                $last_id = $item->count_line->line->id;
            }
            array_push($checked_lines[$item->count_line->line->id], $item->count_line->id);
        }
        $lines = Line::all()->load('counter');
        return response()->json(['success' => true, 'lines' => $lines, 'checked' => $checked_lines]);
    }
}
