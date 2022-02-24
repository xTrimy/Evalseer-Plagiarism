<?php

namespace App\View\Components;

use App\Models\Submission;
use Illuminate\View\Component;

class FailedTestCasesFeedback extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    private $submission;
    private $question;
    public function __construct($submission,$question)
    {
        $this->submission = $submission;
        $this->question = $question;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $submission = $this->submission;
        $question = $this->question;
        $submission_outputs = trim($submission->meta);
        $submission_outputs = explode("\n",$submission_outputs);
        $test_cases = $question->test_cases;
        $output_string = false;
        if(count($test_cases) > 0)
        if(strpos($submission_outputs[0],$test_cases[0]->output)){
            $output_string = str_replace($test_cases[0]->output,'',$submission_outputs[0]);
        }
        return view('components.failed-test-cases-feedback',['outputs'=> $submission_outputs,'test_cases'=>$test_cases,'output_string'=>$output_string]);
    }
}
