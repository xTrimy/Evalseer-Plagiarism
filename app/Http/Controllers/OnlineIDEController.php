<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class OnlineIDEController extends Controller
{
    public function view($id){
        $question = Questions::with(['assignment','test_cases','submissions'=>function(HasMany $query){
            return $query->where('user_id',Auth::user()->id);
        }])->find($id);
        return view('online-ide', ["question"=>$question]);
    }

    public function run(Request $request)
    {
        
        $file_name = "tmp/".time().".cpp";
        file_put_contents($file_name,$request->code);
        $compiler = new QuestionController();
        $submission = new Submission();
        $submission->submitted_code = $file_name;
        $question = Questions::with(['assignment', 'test_cases', 'submissions' => function (HasMany $query) {
            return $query->where('user_id', Auth::user()->id);
        }])->find($request->id);

        $output = $compiler->compile_file('c++', $file_name, "tmp", true);
        $output = str_replace($file_name,'',$output);

        if($request->testing == "true" && $request->submitting == "false"){
            $test_cases_ = $request->only('inputs','output');
            $i= 0;
            $test_case_object = [];
            foreach($test_cases_["inputs"] as $test_case_input){
                $t = [];
                $t["inputs"] = $test_case_input;
                $t["output"] = $test_cases_["output"][$i];
                $test_case_object[] = $t;
                $i++;
            }
            $test_cases = $compiler->run_test_cases_on_submission($test_case_object, 'tmp', $submission, 'c++', true);
        }else{
            $test_cases = $compiler->run_test_cases_on_submission($question->test_cases, 'tmp', $submission, 'c++');
        }
        $full_marks = false;
        $some_test_cases_failed = false;
        $all_test_cases_failed = false;
        if($test_cases == count($question->test_cases) && count($question->test_cases) > 0){
            $full_marks = true;
        }else if($test_cases == 0 && count($question->test_cases) > 0){
            $all_test_cases_failed = true;
        }else{
            $some_test_cases_failed = true;
        }
        $style_feedback = $compiler->style_check($submission,"tmp" , 'c++' ,true);
        if (file_exists("tmp/output.exe"))
            unlink("tmp/output.exe");
        if (file_exists("tmp/output"))
            unlink("tmp/output");

        unlink($file_name);

        $submissions_left = $question->assignment->submissions - count($question->submissions);
        if($output == "0"){
            $output .= "<br><div class='text-yellow-500'>*You can't enter an input here. To test inputs add it to your code or test it through \"Test\" Button</div>";
        }
        return ["style_feedback"=>$style_feedback, "submissions_left" => $submissions_left, "submitting" => $request->submitting,"testing"=>$request->testing, "some_test_cases_failed"=>$some_test_cases_failed,"all_test_cases_failed"=>$all_test_cases_failed,"full_marks"=> $full_marks,"output"=>$output,"test_cases_passed"=>$test_cases."/".count($question->test_cases)];
    }
}
