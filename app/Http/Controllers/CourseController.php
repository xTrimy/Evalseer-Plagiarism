<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function course_groups($id){
        return Course::where('id',$id)->with('groups')->first();
    }
    
    public function view_courses(){
        $user = Auth::user();
        return view('my-courses',['courses'=>$user->courses]);
    }

    public function index($id)
    {
        $course = Course::find($id);
        return view('course', ['course' => $course]);
    }

    public function assignments($id)
    {
        // $course = Course::with(['groups.assignments' => function ($query) {
        //     return $query->whereIn('id', Auth::user()->groups->pluck('id'))->orWhere('id', null);
        // }])->find($id);
        $course = Course::with(['assignments.questions.submissions'=>function($query){
            return $query->where('user_id',Auth::user()->id);
        }])->find($id);
        return view('assignments', ['course' => $course]);
    }


    public function add(){
        return view('admin.add-course');
    }
    private function rand_char($length)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(mt_rand(33, 126));
        }
        return $random;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'course_code' => 'required|string',
            'start_date' => "required|date",
            'end_date' => "required|date",
            'grade' => "required|numeric",
            'grade_to_pass' => "required|numeric",
            'credit_hours' => "required|numeric",
        ]);
        $course = new Course();
        $course->name = $request->name;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->grade_to_pass = $request->grade_to_pass;
        $course->grade = $request->grade;
        $course->course_id = $request->course_code;
        $course->credit_hours = $request->credit_hours;
        $course->active = true;
        $course->access_code = $this->rand_char(6);
        $course->save();
        return redirect()->back()->with('success',"Course Added Successfully! \"Access Code: {$course->access_code}\"");
    }


    public function dashboard_view()
    {
        $courses = Course::paginate(15);
        return view('admin.courses',['courses'=>$courses]);
    }

    public function enroll_user(){
        $students = User::role('student')->get();
        $courses = Course::all();
        return view('admin.enroll-student',['students'=>$students,'courses'=>$courses]);
    }
    public function enroll_user_store(Request $request){
        $request->validate(
            [
                'user_id'=>'required|exists:users,id',
                'course_id'=>'required|exists:courses,id'
            ]
        );
        $user = User::findOrFail($request->user_id);
        $user->courses()->attach($request->course_id);

        return redirect()->back()->with('success','Student Enrolled To Course!');
    }
}
