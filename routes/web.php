<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

//Must be guest routes
Route::middleware('guest')->group(function(){
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', [UserController::class,'login']);
    Route::get('/signup', function () {
        return view('signup');
    })->name('signup');
    Route::post('/signup/createUser', [UserController::class, 'createUser'])->name('createUser');
});

//Must be authenticated routes
Route::middleware('auth')->group(function (){

    // Student routes
    Route::get('/', [CourseController::class, 'view_courses'])->name('home');
    Route::get('/home', function () {
        return redirect()->route('home');
    });
    Route::get('/my-courses', function () {
        return redirect()->route('home');
    })->name('my-courses');


    Route::prefix('/course/{id}')->as('course.')->group(function ($id) {
        Route::get('/', [CourseController::class, 'index'])->name('view');
        Route::get('/assignments', [CourseController::class, 'assignments'])->name('assignments');
    });

    Route::get('/assignment/{id}', [AssignmentController::class, "view"])->name('assignment');
    Route::post('/assignment/{id}', [QuestionController::class, "student_submit"]);

    Route::get('/submission', function () {
        return view('submission');
    });

    Route::prefix('/dashboard')->as('dashboard.')->group(function () {
        
        // Instructor routes
        Route::get('/', function () {
            return view('instructor.index');
        });
        Route::prefix('/assignments')->group(function () {
            Route::get('/add', [AssignmentController::class, "add"]);
            Route::post('/add', [AssignmentController::class, "store"]);
        });
        Route::prefix('/qestions/{id}')->group(function ($id) {
            Route::get('/add', [QuestionController::class, "add"])->name('add_question');
            Route::post('/add', [QuestionController::class, "store"]);
        });


        // Admin routes
        Route::prefix('/courses')->as('courses.')->group(function () {
            Route::get('/', [CourseController::class, "dashboard_view"])->name('view');
            Route::get('/add', [CourseController::class, "add"])->name('add');
            Route::post('/add', [CourseController::class, "store"]);
        });

        Route::prefix('/users')->as('users.')->group(function () {
            Route:: get('/', [UserController::class, "dashboard_users"])->name('view');
            Route::prefix('/students')->as('students.')->group(function () {
                Route:: get('/', [UserController::class, "dashboard_view_students"])->name('view');
                Route::get('/enroll', [CourseController::class, "enroll_user"])->name('enroll');
                Route::post('/enroll', [CourseController::class, "enroll_user_store"]);
            });
            Route::prefix('/instructors')->as('instructors.')->group(function () {
                Route::get('/', [UserController::class, "dashboard_view_instructors"])->name('view');
            });
            Route::get('/add', [UserController::class, "add"])->name('add');
            Route::post('/add', [UserController::class, "store"]);
        });
    });

});


Route::get('/generate_password_for_users',function(){
    $users = User::all();
    foreach($users as $user){
        if(strlen($user->password) <60){
            $user->password = bcrypt($user->password);
        }
    }
});


