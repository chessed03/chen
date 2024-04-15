<?php

namespace App\Http\Controllers\School\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    
    const MODULE    = 'Escuela';
    const SUBMODULE = 'Grupos';

    public function index(Request $request)
    {
        return view('schools.groups.index', [
            'module'    => self::MODULE,
            'submodule' => self::SUBMODULE,
        ]);
    }

}
