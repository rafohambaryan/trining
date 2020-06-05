<?php

namespace App\Http\Controllers\Backend;

use App\Repository\Backend\Interfaces\GenreRepositoryInterfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    /**
     * @var GenreRepositoryInterfaces
     */
    protected $interfaces;

    /**
     * GenreController constructor.
     * @param GenreRepositoryInterfaces $interfaces
     */
    public function __construct(GenreRepositoryInterfaces $interfaces)
    {
        $this->interfaces = $interfaces;
    }

    public function get()
    {
        return response()->json($this->interfaces->get(),200);
    }
}
