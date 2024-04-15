<?php

use App\Http\Controllers\School\StaffPosition\StaffPositionController;
use App\Http\Controllers\School\StaffType\StaffTypeController;
use App\Http\Controllers\School\Degree\DegreeController;
use App\Http\Controllers\School\Shift\ShiftController;
use App\Http\Controllers\School\Group\GroupController;
use App\Http\Controllers\Semester\SemesterController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\Career\CareerController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {

    #Routes home
    Route::controller(HomeController::class)
        ->prefix('home')
        ->as('home.')
        ->group(function () {
            
            Route::get('/', 'index')->name('index');

        }
    );

    #Routes school
    Route::controller(SchoolController::class)
        ->prefix('school')
        ->as('school.')
        ->group(function () {
            
            Route::get('/', 'index')->name('index');


            #Routes shift
            Route::controller(ShiftController::class)
            ->prefix('shift')
            ->as('shift.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            });

            #Routes degree
            Route::controller(DegreeController::class)
            ->prefix('degree')
            ->as('degree.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            });

             #Routes group
             Route::controller(GroupController::class)
             ->prefix('group')
             ->as('group.')
             ->group(function () {
                 
                 Route::get('/', 'index')->name('index');
 
             });

            #Routes staff position
            Route::controller(StaffPositionController::class)
            ->prefix('staff-position')
            ->as('staff-position.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            });

             #Routes staff type
             Route::controller(StaffTypeController::class)
             ->prefix('staff-type')
             ->as('staff-type.')
             ->group(function () {
                 
                 Route::get('/', 'index')->name('index');
 
             });

        }
        
    );

    #Routes career
    Route::controller(CareerController::class)
        ->prefix('career')
        ->as('career.')
        ->group(function () {
            
            Route::get('/', 'index')->name('index');

        }
    );

    #Routes semester
    Route::controller(SemesterController::class)
        ->prefix('semester')
        ->as('semester.')
        ->group(function () {
            
            Route::get('/', 'index')->name('index');

        }
    );

    #Routes subject
    Route::controller(SubjectController::class)
        ->prefix('subject')
        ->as('subject.')
        ->group(function () {
            
            Route::get('/', 'index')->name('index');

        }
    );


});
