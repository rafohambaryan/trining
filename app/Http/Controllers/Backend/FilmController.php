<?php

namespace App\Http\Controllers\Backend;

use App\Events\FilmEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

class FilmController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function films()
    {
        return view('backend.films', ['films' => Event::dispatch(new FilmEvent('getAuth'), true, true)]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrUpdate(Request $request, $id = 0)
    {
        $film = Event::dispatch(new FilmEvent('createOrUpdate', $request, $id), true, true);
        $response['success'] = false;
        if ($film) {
            $response['success'] = true;
            $response['data'] = $film;
        }
        return response()->json($response, 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function find($id)
    {
        $film = Event::dispatch(new FilmEvent('find', $id), true, true);
        if ($film) {
            return response()->json(['success' => true, 'data' => $film->load('getDate', 'getGenre')]);
        }
        return response()->json(['success' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleted(Request $request)
    {
        return response()->json(Event::dispatch(new FilmEvent('deleted', $request->input('film_id')), true, true));
    }
}
