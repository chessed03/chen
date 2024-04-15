<?php

namespace App\Http\Controllers\School\StaffType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffTypeController extends Controller
{
    
    const MODULE    = 'Escuela';
    const SUBMODULE = 'Tipos de personal';

    public function index(Request $request)
    {
        return view('schools.staff-types.index', [
            'module'    => self::MODULE,
            'submodule' => self::SUBMODULE,
        ]);
    }

}
