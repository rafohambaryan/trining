<?php

namespace App\Http\Controllers;

use App\Repository\Backend\Interfaces\DateFilmRepositoryInterfaces;
use App\Repository\Backend\NoBind\SearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var
     */
    public $searchContent;
    /**
     * @var SearchRepository
     */
    protected $repository;

    /**
     * SearchController constructor.
     * @param SearchRepository $repository
     */
    public function __construct(SearchRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchDate(Request $request)
    {
        if ($request->has('date'))
            $this->searchContent['date'] = $request->input('date');
        if ($request->has('genre'))
            $this->searchContent['genre'] = $request->input('genre');
        return response()->json($this->repository->search($this->searchContent));
    }
}
