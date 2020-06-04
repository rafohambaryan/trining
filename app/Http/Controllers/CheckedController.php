<?php

namespace App\Http\Controllers;

use App\Repository\Backend\Interfaces\CheckedRepositoryInterfaces;
use Illuminate\Http\Request;

class CheckedController extends Controller
{
    protected $interfaces;

    public function __construct(CheckedRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checked(Request $request)
    {
        $data['film_id'] = $request->input('film');
        $data['date_film_id'] = $request->input('date');
        $data['count_line_id'] = $request->input('count');
        return response()->json($this->interfaces->checked($data));
    }
}
