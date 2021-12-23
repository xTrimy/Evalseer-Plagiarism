<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/registration', function () {
    return view('registration');
});

Route::get('/course', function () {
    return view('course');
});

Route::get('/assignments', function () {
    return view('assignments');
});

Route::get('/submission', function () {
    return view('submission');
});

Route::get('/my-courses', function () {
    return view('my-courses');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/', [SubmitController::class,"submit"]);

Route::post('/signup/createUser', [UserController::class, 'createUser'])->name('createUser');

Route::prefix('/dashboard')->group(function(){
    Route::get('/', function(){
        return view('instructor.index');
    });
    Route::prefix('/assignments')->group(function () {
        Route::get('/add', [AssignmentController::class, "add"]);
        Route::post('/add', [AssignmentController::class, "store"]);
    });
    Route::prefix('/qestions/{id}')->group(function ($id) {
        Route::get('/add', [QuestionController::class, "add"])->name('add_question');
        Route::post('/add', [AssignmentController::class, "store"]);
    });

});
