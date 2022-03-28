<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Submission;
use Illuminate\Http\Request;

class OnlineIDEController extends Controller
{
    public function view($id){
        $question = Questions::find($id);
        return view('online-ide', ["question"=>$question]);
    }

    public function run(Request $request)
    {
        $file_name = "tmp/".time().".cpp";
        file_put_contents($file_name,$request->code);
        $compiler = new QuestionController();
        $submission = new Submission();
        $submission->submitted_code = $file_name;
        $question = Questions::with('test_cases')->find($request->id);

        $output = $compiler->compile_file('c++', $file_name, "tmp", true);
        $output = str_replace($file_name,'',$output);


        $test_cases = $compiler->run_test_cases_on_submission($question->test_cases,'tmp',$submission,'c++');
        $full_marks = false;
        if($test_cases == count($question->test_cases)){
            $full_marks = true;
        }
        $style_feedback = $compiler->style_check($submission,"tmp" , 'c++' ,true);

        unlink($file_name);
        return ["style_feedback"=>$style_feedback,"full_marks"=> $full_marks,"output"=>$output,"test_cases_passed"=>$test_cases."/".count($question->test_cases)];
    }
}
