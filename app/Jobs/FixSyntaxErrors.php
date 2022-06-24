<?php

namespace App\Jobs;

use App\Http\Controllers\QuestionController;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FixSyntaxErrors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $submission;
    public $assignment_submission_path;
    public $lang;
    public $question;

    public function __construct(Submission &$submission, $assignment_submission_path, $lang, $question)
    {
        $this->submission = $submission;
        $this->assignment_submission_path = $assignment_submission_path;
        $this->lang = $lang;
        $this->question = $question;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->submission->compile_feedback == null) {
            return;
        }
        $submission = $this->submission;
        $assignment_submission_path = $this->assignment_submission_path;
        $compiler_feedback = json_decode($submission->compile_feedback, true);
        $compiler_feedback["condition"] = "processing";
        $compiler_feedback["last_update"] = date("Y-m-d H:i:s");
        $submission->compile_feedback = json_encode($compiler_feedback);
        $submission->save();
        $evalseer_feedback = shell_exec(env('SYNTAX_CORRECTION_PY') . " \"" . public_path($submission->submitted_code) . "\" 2>&1");
        //split {"status" from $evalseer_feedback
        $compiler_feedback["condition"] = "done";
        $compiler_feedback["last_update"] = date("Y-m-d H:i:s");
        $submission->compile_feedback = json_encode($compiler_feedback);
        $submission->save();
        $evalseer_feedback = explode("{\"status", $evalseer_feedback);
        //check index exists in array
        if (isset($evalseer_feedback[1])) {
            $evalseer_feedback = "{\"status" . $evalseer_feedback[1];
        } else if (isset($evalseer_feedback[0])) {
            $evalseer_feedback = "{\"status" . $evalseer_feedback[0];
        } else {
            $evalseer_feedback = "{\"status\":\"error\"}";
        }
        $evalseer_feedback = json_decode($evalseer_feedback, true);
        foreach ($evalseer_feedback as $key => $value) {
            $compiler_feedback[$key] = $value;
        }
        if ($compiler_feedback["status"] == "success") {
            $corrected_code_path = public_path($assignment_submission_path) . "/fixed.cpp";
            $file = fopen($corrected_code_path, 'w');
            fwrite($file, $compiler_feedback["solution"]);
            fclose($file);
            $cpp_executable = env('CPP_EXE_PATH');
            $output_1 = shell_exec("$cpp_executable \"" . $corrected_code_path . "\" -o \"" . public_path($assignment_submission_path) . "/output\" 2>&1");
        }
        $submission->compile_feedback = json_encode($compiler_feedback);
        $question_controller = new QuestionController();
        $number_of_test_cases_passed = $question_controller->run_test_cases_on_submission($this->question, $this->question->test_cases, $assignment_submission_path, $submission, $this->lang);
        $number_of_test_cases = count($this->question->test_cases);
        $submission->logic_feedback = "Number of Test Cases Passed: $number_of_test_cases_passed/$number_of_test_cases";

        $submission->save();
    }
}
