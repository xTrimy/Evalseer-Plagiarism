<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ProgrammingLanguage;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('course', ['course' => $course,'course_title'=>$course->name]);
    }

    public function assignments($id)
    {
        // $course = Course::with(['groups.assignments' => function ($query) {
        //     return $query->whereIn('id', Auth::user()->groups->pluck('id'))->orWhere('id', null);
        // }])->find($id);
        $course = Course::with(['assignments.questions.submissions'=>function(HasMany $query){
            return $query->where('user_id','=',Auth::user()->id);
        }])->find($id);
        return view('assignments', ['course' => $course]);
    }


    public function add(){
        $programming_languages = ProgrammingLanguage::all();
        return view('admin.add-course',['programming_languages'=>$programming_languages]);
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
            'programming_languages' => "array",
            'programming_languages.*' => "numeric|exists:programming_languages,id",
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
        foreach ($request->programming_languages as $lang) {
            $course->programming_languages()->attach($lang);
        }
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

    public function view_course($course_id) {
        // $students = DB::table('course_user')
        // ->where('course_id',$course_id)
        // ->leftJoin('users', 'course_user.user_id', '=', 'users.id')
        // ->leftJoin('model_has_roles', 'course_user.user_id', '!=', 'model_has_roles.model_id')
        // ->where('role_id','1')
        // // ->select('course_user.*')
        // ->select('users.*')
        // ->get();

        $students = User::role('student')->whereHas('courses',function($query) use($course_id){
            $query->where('courses.id',$course_id);
       })->get();


        // dd($students);

        // $studentsAll = DB::table('course_user')
        // ->where('course_id',$course_id)
        // ->leftJoin('users', 'course_user.user_id', '!=', 'users.id')
        // ->leftJoin('model_has_roles', 'course_user.user_id', '!=', 'model_has_roles.model_id')
        // ->where('role_id','1')
        // ->select('users.*')
        // ->get();

        $studentsAll = User::role('student')->whereDoesntHave('courses',function($query) use($course_id){
            $query->where('courses.id',$course_id);
       })->get();

        // dd($studentsAll);


        return view('admin.view-course',['students'=>$students,'studentsAll'=>$studentsAll,'course_id'=>$course_id]);
    }

    public function assign_to_course($user_id, $course_id) {
        $user = User::findOrFail($user_id);
        $user->courses()->attach($course_id);

        return redirect()->back()->with('success','Student Enrolled To Course!');
    }

    public function remove_from_course($user_id, $course_id) {
        $user = User::findOrFail($user_id);
        $user->courses()->detach($course_id);

        return redirect()->back()->with('success','Student Enrolled To Course!');
    }

    public function edit_course($course_id) {
        $course = Course::find($course_id);
        $programming_languages = ProgrammingLanguage::all();
        return view('admin.edit-course',['course'=>$course,'programming_languages'=>$programming_languages]);
    }

    public function edit(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'course_code' => 'required|string',
            'start_date' => "required|date",
            'end_date' => "required|date",
            'grade' => "required|numeric",
            'grade_to_pass' => "required|numeric",
            'credit_hours' => "required|numeric",
            'programming_languages' => "array",
            'programming_languages.*' => "numeric|exists:programming_languages,id",
        ]);

        // dd($request->name);
        $course = Course::find($request->course_id);
        // dd($request->active);
        $course->name = $request->name;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->grade_to_pass = $request->grade_to_pass;
        $course->grade = $request->grade;
        $course->course_id = $request->course_code;
        $course->credit_hours = $request->credit_hours;
        if($request->active == "on") {
            $course->active = true;
        } else {
            $course->active = false;
        }
        $course->access_code = $this->rand_char(6);
        $course->save();
        
        if ($request->programming_languages != null) {
            foreach ($request->programming_languages as $lang) {
                $course->programming_languages()->attach($lang);
            }
        }
        return redirect()->back()->with('success',"Course Edited Successfully! \"Access Code: {$course->access_code}\"");
    }

    public function delete($course_id){
        $course = Course::find($course_id);
        $course->delete();

        return redirect()->back()->with('success',"Course deleted successfully");
    }

    public function student_enroll($course_id) {
        $course = Course::find($course_id);

        $student = Auth::user();

        return view('enroll-course',['course'=>$course]);
    }

    public function student_enroll_code(Request $request) {
        $request->validate([
            'access_code' => 'required|string'
        ]);

        // dd($request);

        $course = Course::where('access_code',$request->access_code)->first();

        if ($course == null) {
            return redirect()->back()->with('error','Invalid Access Code');
        }

        $student = Auth::user();

        $student->courses()->attach($course->id);

        return redirect()->back()->with('success','Course Enrolled Successfully!');
    }
}
