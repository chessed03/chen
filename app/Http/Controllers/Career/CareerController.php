<?php

namespace App\Http\Controllers\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    const MODULE    = 'Carreras';

    public function index(Request $request)
    {
        return view('careers.index', [
            'module'    => self::MODULE,
        ]);
    }
}
