<?php

namespace App\Http\Controllers\School\Shift;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    
    const MODULE    = 'Escuela';
    const SUBMODULE = 'Turnos';

    public function index(Request $request)
    {
        return view('schools.shifts.index', [
            'module'    => self::MODULE,
            'submodule' => self::SUBMODULE,
        ]);
    }

}
