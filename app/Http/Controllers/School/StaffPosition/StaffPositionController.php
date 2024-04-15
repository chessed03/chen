<?php

namespace App\Http\Controllers\School\StaffPosition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffPositionController extends Controller
{
    
    const MODULE    = 'Escuela';
    const SUBMODULE = 'Puestos de personal';

    public function index(Request $request)
    {
        return view('schools.staff-positions.index', [
            'module'    => self::MODULE,
            'submodule' => self::SUBMODULE,
        ]);
    }

}
