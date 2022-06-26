<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/course/{id}/groups',[CourseController::class,'course_groups']);

Route::get('/test', function(){
    $course_id = 1;
    $x = User::role('student')->whereDoesntHave('courses',function($query) use($course_id){
         $query->where('courses.id',$course_id);
    })->get();
    return $x;
});
