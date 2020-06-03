<?php

namespace App\Http\Controllers\Backend;

use App\Models\Line;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HallController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lines = Line::all();
        return view('backend.hall', compact('lines'));
    }

    public function addLine()
    {

    }

    public function addLineCount()
    {

    }
}
