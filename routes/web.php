<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlagiarismController;
use App\Http\Controllers\BadgeController;
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

    Route::get('/jplag', function () {
        return view('home');
    })->name('jplag');

    Route::post('/signup/createUser', [UserController::class, 'createUser'])->name('createUser');
});

//Must be authenticated routes
Route::middleware('auth')->group(function (){

    Route::get('/jplag', function () {
        return view('home');
    })->name('jplag');

    Route::post('/submit', [SubmitController::class,'submit']);

    // Student routes
    Route::get('/', [CourseController::class, 'view_courses'])->name('home');
    Route::get('/home', function () {
        return redirect()->route('home');
    });
    Route::get('/my-courses', function () {
        return redirect()->route('home');
    })->name('my-courses');

    Route::get('/badges', [BadgeController::class, "view"])->name('view_badges');
    
    Route::get('/logout', [UserController::class, "logout"])->name('logout');

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

        Route::get('/form-zip', [PlagiarismController::class, "formZip"]);
        // Instructor routes
        Route::get('/', function () {
            return view('instructor.index');
            
        });
        Route::prefix('/assignments')->as('assignments.')->group(function () {
            Route::get('/add', [AssignmentController::class, "add"])->name('add_assignment');
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

            Route::get('/view_course/{course_id}', [CourseController::class, "view_course"])->name('view-course');

            Route::get('/edit-course/{course_id}', [CourseController::class, "edit_course"])->name('edit-course');
            Route::post('/edit-course/{course_id}', [CourseController::class, "edit"]);

            Route::get('/delete/{course_id}', [CourseController::class, "delete"])->name('delete');
        });

        Route::prefix('/users')->as('users.')->group(function () {
            Route:: get('/', [UserController::class, "dashboard_users"])->name('view');
            Route::prefix('/students')->as('students.')->group(function () {
                Route:: get('/', [UserController::class, "dashboard_view_students"])->name('view');
                Route::get('/enroll', [CourseController::class, "enroll_user"])->name('enroll');
                Route::post('/enroll', [CourseController::class, "enroll_user_store"]);


                Route::get('/assign-to-course/{user_id}/{course_id}', [CourseController::class, "assign_to_course"])->name('assign-to-course');
                Route::get('/remove-from-course/{user_id}/{course_id}', [CourseController::class, "remove_from_course"])->name('remove-from-course');
            });
            Route::prefix('/instructors')->as('instructors.')->group(function () {
                Route::get('/', [UserController::class, "dashboard_view_instructors"])->name('view');
            });
            Route::prefix('/instructors')->as('instructors.')->group(function ($assignment_id) {
                Route::get('/view-assignments', [UserController::class, "dashboard_view_assignments"])->name('view_assignments');
                Route::post('/delete', [AssignmentController::class, "delete"]);
            });
            Route::prefix('/instructors')->as('instructors.')->group(function ($assignment_id) {
                Route::get('/view-assignments-questions/{assignment_id}', [UserController::class, "view_assignment_questions"])->name('view_assignment_questions');
            });

            Route::prefix('/instructors')->as('instructors.')->group(function ($question_id) {
                Route::get('/edit-question/{question_id}', [QuestionController::class, "edit"])->name('edit_question');
                Route::get('/delete-question/{question_id}', [QuestionController::class, "delete_question"])->name('delete_question');
                Route::post('/edit-question/{question_id}', [QuestionController::class, "edit_question"]);
            });
            
            Route::prefix('/instructors')->as('instructors.')->group(function ($assignment_id) {
                Route::get('/edit-assignment/{assignment_id}', [AssignmentController::class, "edit_assignment"])->name('edit_assignment');
                Route::post('/edit-assignment/{assignment_id}', [AssignmentController::class, "edit"]);
                // Route::post('/edit-assignment/{assignment_id}', [QuestionController::class, "delete"]);
            });
            Route::prefix('/instructors')->as('instructors.')->group(function ($question_id) {
                Route::get('/view-question-submission/{question_id}', [UserController::class, "view_question_submission"])->name('view_question_submission');
            });

            Route::prefix('/instructors')->as('instructors.')->group(function ($submission_id) {
                Route::get('/view-submission/{submission_id}', [UserController::class, "view_submission"])->name('view_submission');

                Route::get('/edit-submission/{submission_id}', [UserController::class, "edit_submission"])->name('edit_submission');
                Route::post('/edit-submission/{submission_id}', [UserController::class, "edit_sub"]);
            });

            Route::prefix('/instructors')->as('instructors.')->group(function () {
                Route::get('/run-plag/{zipPath}/{type}/{question_id}', [PlagiarismController::class, "run_plag"])->name('run_plag');

                Route::get('/plagiarism-report', [PlagiarismController::class, "plagiarism_report"])->name('plagiarism_report');
            });

            Route::prefix('/instructors')->as('instructors.')->group(function ($user_id) {
                Route::get('/edit-user/{user_id}', [UserController::class, "edit_user"])->name('edit-user');
                Route::post('/edit-user/{user_id}', [UserController::class, "edit"]);

                Route::get('/delete-user/{user_id}', [UserController::class, "delete_user"])->name('delete-user');
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
            $user->save();
        }
    }
});


Route::get('/assign_all_users_to_computer_science_course', function () {
    $users = User::all();
    foreach ($users as $user) {
        if($user->hasRole('student'))
            continue;
        $user->assignRole('student');
        $user->courses()->attach(1);
    }
});


