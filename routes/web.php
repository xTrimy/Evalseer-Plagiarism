<?php

use App\Http\Controllers\SubmitController;
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

Route::post('/', [SubmitController::class,"submit"]);