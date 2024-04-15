<?php

namespace App\Http\Controllers\School\Degree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    
    const MODULE    = 'Escuela';
    const SUBMODULE = 'Grados';

    public function index(Request $request)
    {
        return view('schools.degrees.index', [
            'module'    => self::MODULE,
            'submodule' => self::SUBMODULE,
        ]);
    }
    
}
