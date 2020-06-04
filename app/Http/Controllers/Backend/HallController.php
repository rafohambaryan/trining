<?php

namespace App\Http\Controllers\Backend;

use App\Models\Line;
use App\Repository\Backend\Interfaces\LineRepositoryInterfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HallController extends Controller
{
    protected $interfaces;

    public function __construct(LineRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backend.hall', ['lines' => $this->interfaces->get()]);
    }

    public function addLine()
    {

    }

    public function addLineCount()
    {

    }
}
