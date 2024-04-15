<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    const MODULE    = 'Escuela';

    public function index(Request $request)
    {
        return view('schools.index', [
            'module'    => self::MODULE,
        ]);
    }
}
