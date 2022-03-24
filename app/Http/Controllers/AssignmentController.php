<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function add(){
        $courses = Course::all();
        return view('instructor.add-assignment',['courses'=>$courses]);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description' => 'nullable|string',
            'start_time'=> "required|date",
            'end_time' => "required|date",
            'late_time' => "required|date",
            'max' => "required|numeric",
            'grade' => "required|numeric",
            'pdf' => "nullable|mimes:pdf",
            'course_id' => "required|exists:courses,id",
            'group_id' => "nullable|exists:groups,id",
        ]);
        $assignment = new Assignments();
        $assignment->name = $request->name;
        if($request->has('description'))
            $assignment->description = $request->description;
        
        $assignment->start_time = $request->start_time;
        $assignment->end_time = $request->end_time;
        $assignment->late_time = $request->late_time;
        $assignment->submissions = $request->max;
        $assignment->grade = $request->grade;
        $assignment->course_id = $request->course_id;
        if($request->has('group_id'))
            $assignment->group_id = $request->group_id;
        if($request->hasFile('pdf')){
            $filenameWithExt = $request->file('pdf')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('pdf')->getClientOriginalExtension();
            $fileNameToStore = $request->name . '-' . time() . '.' . $extension;
            $path = $request->file('pdf')->storeAs('public/file', $fileNameToStore);
            $assignment->pdf = $fileNameToStore;
        }
        $assignment->save();
        return redirect()->route('dashboard.add_question',$assignment->id);
    }

    public function edit_assignment($assignment_id) {
        // dd($assignment_id);
        $users = User::role('instructor')->paginate(15);

        $courses = Course::all();

        $questions = DB::table('questions')
                        ->where('assignment_id',$assignment_id)
                        ->select('questions.*')
                        ->get();

        $assignment = DB::table('assignments')
        ->where('id',$assignment_id)
        // ->leftJoin('courses', 'assignments.course_id', '=', 'courses.id')
        ->select('assignments.*')
        ->first();

        $coursesSel = DB::table('courses')
                    ->where('id',$assignment->course_id)
                    ->select('courses.*')
                    ->first();

        return view('admin.edit-assignment',['users'=>$users,'questions'=>$questions,'assignment'=>$assignment,'courses'=>$courses,'coursesSel'=>$coursesSel]);
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required|string',
            'description' => 'nullable|string',
            'start_time'=> "required|date",
            'end_time' => "required|date",
            'late_time' => "required|date",
            'max' => "required|numeric",
            'grade' => "required|numeric",
            'pdf' => "nullable|mimes:pdf",
            'course_id' => "required|exists:courses,id",
            'group_id' => "nullable|exists:groups,id",
        ]);
        $assignment = Assignments::find($request->assignment_id);
        $assignment->name = $request->name;
        if($request->has('description'))
            $assignment->description = $request->description;
        
        $assignment->start_time = $request->start_time;
        $assignment->end_time = $request->end_time;
        $assignment->late_time = $request->late_time;
        $assignment->submissions = $request->max;
        $assignment->grade = $request->grade;
        $assignment->course_id = $request->course_id;
        if($request->has('group_id'))
            $assignment->group_id = $request->group_id;
        if($request->hasFile('pdf')){
            $filenameWithExt = $request->file('pdf')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('pdf')->getClientOriginalExtension();
            $fileNameToStore = $request->name . '-' . time() . '.' . $extension;
            $path = $request->file('pdf')->storeAs('public/file', $fileNameToStore);
            $assignment->pdf = $fileNameToStore;
        }
        $assignment->save();
        return redirect()->route('dashboard.users.instructors.view_assignments');
    }

    public function view($id){
        $assignment = Assignments::with(['questions.test_cases', 'questions.grading_criteria', 'questions.submissions'=>function(HasMany $query){
            return $query->where('user_id',Auth::user()->id);
        }])->find($id);
        $submission_allowed = (strtotime($assignment->start_time) <= time() && strtotime($assignment->end_time) >= time())?true:false;
        return view('submission',["assignment"=>$assignment,'submission_allowed'=>$submission_allowed]);
    }

    public function submit_assignment(Request $request){
        $request->validate([
            "submission.*"=>"required|array",
        ]);
    }

    public function delete(Request $request){
        $assignment = Assignments::find($request->assignment_id);
        $assignment->delete();

        return redirect()->route('dashboard.users.instructors.view_assignments');
    }
    
}
