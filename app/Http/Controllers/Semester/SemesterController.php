<?php

namespace App\Http\Controllers\Semester;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    const MODULE    = 'Semestres';

    public function index(Request $request)
    {
        return view('semesters.index', [
            'module'    => self::MODULE,
        ]);
    }
}
