<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    const MODULE    = 'Materias';

    public function index(Request $request)
    {
        return view('subjects.index', [
            'module'    => self::MODULE,
        ]);
    }
}
