<?php

namespace App\Http\Controllers\Backend;

use App\Repository\Backend\Interfaces\GenreRepositoryInterfaces;
use App\Repository\Backend\Interfaces\UnitRepositoryInterfaces;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    /**
     * @var GenreRepositoryInterfaces
     */
    protected $interfaces;
    protected $units;

    /**
     * GenreController constructor.
     * @param GenreRepositoryInterfaces $interfaces
     * @param UnitRepositoryInterfaces $units
     */
    public function __construct(GenreRepositoryInterfaces $interfaces, UnitRepositoryInterfaces $units)
    {
        $this->interfaces = $interfaces;
        $this->units = $units;
    }

    public function get()
    {
        return response()->json(['genre' => $this->interfaces->get(), 'units' => $this->units->get()], 200);
    }
}
