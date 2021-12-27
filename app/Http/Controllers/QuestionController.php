<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\Questions;
use App\Models\QuestionTestCases;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function add($id){
        $assignment = Assignments::find($id);
        return view('instructor.add-question',["assignment"=>$assignment]);
    }
    public function store(Request $request){
        $request->validate([
            'assignment_id'=>"required|exists:assignments,id",
            'name'=>"required|string",
            'description' => "required|string",
            'grade' => "required|numeric",
            'input' => "nullable|array",
            'output' => "nullable|array",
        ]);

        $question = new Questions();
        $question->name = $request->name;
        $question->assignment_id = $request->assignment_id;
        $question->description = $request->description;
        $question->grade = $request->grade;
        $question->save();
        $i = 0;
        foreach($request->input as $input){
            if($i>0){
                $question_test_case = new QuestionTestCases();
                $question_test_case->inputs = $input;
                $question_test_case->output = $request->output[$i];
                $question_test_case->question_id = $question->id;
                $question_test_case->save();
            }
            $i++;
        }
        return redirect()->back()->with('success',"Question added successfully");
    }

    public function student_submit(Request $request){
        $request->validate([
            'question_id'=>'required|exists:questions,id',
            'submission'=>'file|required'
        ]);
        $question = Questions::with(['assignment','submissions', 'test_cases'])->find($request->question_id);
        $submission = new Submission();
        $extension = $request->file('submission')->getClientOriginalExtension();
        $fileNameToStore = $request->name . '-' . time() . '.' . $extension;
        $submission_number = count($question->submissions)+1;
        $user_name = Auth::user()->name . ' - ' . str_replace('\\','-',str_replace("/", "-", Auth::user()->university_id));
        $assignment_submission_path = "/assignment_submissions/{$question->assignment->name}/{$question->name}/$user_name/$submission_number";
        $request->submission->move(public_path($assignment_submission_path), $fileNameToStore);
        $submission->submitted_code = $assignment_submission_path.'/'. $fileNameToStore;
        $submission->question_id = $question->id;
        $cpp_executable = env('CPP_EXE_PATH');
        shell_exec("$cpp_executable \"" . public_path($submission->submitted_code) . "\" -o \"" . public_path($assignment_submission_path) . "/output\"");
        $number_of_test_cases_passed=0;
        foreach ($question->test_cases as $test_case){
            $test_case_file = public_path($assignment_submission_path . "/test_case_".$test_case->id);
            file_put_contents($test_case_file, $test_case->inputs);
            $output = shell_exec("\"". public_path($assignment_submission_path) . "/output\" < \"". $test_case_file."\"");
            if($output == $test_case->output){
                $number_of_test_cases_passed +=1;
            }
            $submission->meta .= "\n".$output;
        }
        $number_of_test_cases = count($question->test_cases);
        $submission->logic_feedback = "Number of Test Cases Passed: $number_of_test_cases_passed/$number_of_test_cases";
        $submission->save();
        
        return redirect()->back()->with('question_'.$request->question_id,"Answer Submitted for {$question->name}");
    }
}
