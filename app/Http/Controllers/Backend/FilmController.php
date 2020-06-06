<?php

namespace App\Http\Controllers\Backend;

use App\Models\Film;
use App\Repository\Backend\Interfaces\FilmRepositoryInterfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $this->interfaces = $interfaces;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function films()
    {
        return view('backend.films', ['films' => $this->interfaces->get()]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrUpdate(Request $request, $id = 0)
    {
        $film = $this->interfaces->createOrUpdate($request->all(), $id);
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
        $film = $this->interfaces->find($id);
        if ($film) {
            return response()->json(['success' => true, 'data' => $film->load('getDate','getGenre')]);
        }
        return response()->json(['success' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleted(Request $request)
    {
        return response()->json($this->interfaces->deleted($request->input('film_id')));
    }
}
