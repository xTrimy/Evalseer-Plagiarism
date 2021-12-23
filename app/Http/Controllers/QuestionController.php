<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\Questions;
use App\Models\QuestionTestCases;
use Illuminate\Http\Request;

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
}
