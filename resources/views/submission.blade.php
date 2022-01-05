@extends('layout.app')
@section('title')
{{ $assignment->name }}
@endsection
@section('content')
@if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
    <div class="flex w-full">
            <div class="w-3/4 p-8 bg-gray-200 m-auto rounded-3xl shadow-md">
            <div class="flex-1 flex py-2 px-8 bg-gray-200 rounded-3xl mr-10 items-center mb-8">
                <table class="w-full">
                    <tr class="mb-6">
                        <td >
                            <div class="mr-12 text-center">
                                <i class="fas fa-book text-green-600 text-4xl"></i>
                            </div>
                        </td>
                        <td>
                            <div class="text-center w-full">
                                <p class="w-full text-left font-bold text-xl">{{ $assignment->name }}</p>
                                <p class="text-left font-bold text-xl">Opened: <span class="text-left font-normal">{{ $assignment->start_time->format('l, d F, H:i A') }}</span> </p>
                                <p class="w-full text-left font-bold text-xl">Due: <span class="text-left font-normal">{{ $assignment->end_time->format('l, d F, H:i A') }}</span></p>
                            </div>
                        </td> 
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <table class="mt-6 space-y-4 w-full">
                                {{-- <tr class="mb-8 bg-gray-300 ">
                                    <td class="font-bold text-xl pr-12 py-4 px-3">Submission status</td>
                                    <td class="text-xl">No attempt</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Grade</td>
                                    <td class="text-xl">Not graded</td>
                                </tr> --}}
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Time remaining</td>
                                    {{-- <td class="text-xl text-red-800">Assignment is overdue by: 53 days 18 hours</td> --}}
                                    <td class="text-xl ">{{ $assignment->end_time->diffForHumans() }}</td>
                                </tr>
                                {{-- <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Last modified</td>
                                    <td class="text-xl">-</td>
                                </tr> --}}
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
    @foreach ($assignment->questions as $question)
    @php
        $submission = $question->submissions->last() ?? null;
    @endphp
    <div class="w-3/4 mx-auto">
        <div class="w-full py-8 text-left">
            <div class="bg-gray-200 rounded-lg p-8 shadow-md">
            @if(Session::has('question_'.$question->id))
            <div id="success_submission" class="w-full py-4 px-8 text-green-700 bg-green-300 mb-4 rounded-md shadow flex">
                <div class="flex-1">
                    {{ Session::get('question_'.$question->id) }}
                    <script>
                        document.addEventListener("DOMContentLoaded", function(){
                            var success_submission = document.getElementById("success_submission");
                            success_submission.scrollIntoView();
                        });
                    </script>
                </div>
                {{-- <div class="cursor-pointer border-l border-gray-100 px-4 flex place-items-center">
                    <p class="text-white text-xl text-center"><i class="fas fa-times"></i></p>
                </div> --}}
            </div>
            @endif
            <div class=" bg-white w-full shadow rounded-md px-4">
                <h1 class="text-gray-800 text-2xl p-2 font-bold">
                   Question: {{ $question->name }}</h1>
                <p class="text-gray-800 text-lg p-2  "><i class="las la-align-left"></i> Description: {{ $question->description }}</p>
                <p class="text-gray-800 text-lg p-2  "><i class="las la-file"></i> Remaining Submissions: {{ $assignment->submissions-count($question->submissions) }}</p>
                <p class="text-gray-800 text-lg p-2  ">
                    @if(count($question->submissions)>0)
                    <i class="las la-check text-xl text-green-500"></i> Status:  Submitted at {{ $question->submissions->last()->created_at->format('l, d F, H:i A') }}
                    @else
                    <i class="las la-times text-xl text-red-500"></i> Status:  Not Submitted
                    @endif
                </p>
            </div>
            
            @if(count($question->submissions)>0)
            <div class="flex mt-5">
                <div class="flex bg-white flex-row shadow-md border border-gray-100 rounded-lg overflow-hidden md:w-5/12 mx-2">
                    <div class="flex w-3 bg-gradient-to-t from-green-500 to-green-400"></div>
                    <div class="flex-1 p-3">
                      <h1 class="md:text-xl text-gray-600">Number of Test Cases Passed</h1>
                      <p class="text-gray-400 text-xs md:text-sm font-light">{{ $question->submissions->last()->logic_feedback }}</p>
                    </div>
                    <div class="border-l border-gray-100 px-8 flex place-items-center">
                      <p class="text-gray-400 text-xs"><i class="fas fa-check"></i></p>
                    </div>
                </div>
                <div class="flex bg-white flex-row shadow-md border border-gray-100 rounded-lg overflow-hidden md:w-5/12 mx-2">
                    <div class="flex w-3 bg-gradient-to-t 
                    @if( $question->submissions->last()->total_grade/$question->grade >= 0.5 )
                    from-green-500 to-green-400
                    @else
                    from-red-500 to-red-400
                    @endif
                    "></div>
                    <div class="flex-1 p-3">
                      <h1 class="md:text-xl text-gray-600">Grade</h1>
                      <p class="text-gray-400 text-xs md:text-sm font-light">{{ $question->submissions->last()->total_grade }}/{{ $question->grade }}</p>
                    </div>
                    <div class="border-l border-gray-100 px-8 flex place-items-center">
                      <p class="text-gray-400 text-xs"><i class="fas fa-percent"></i></p>
                    </div>
                </div>
                <div class="flex bg-white flex-row shadow-md border border-gray-100 rounded-lg overflow-hidden md:w-5/12 mx-2">
                    <div class="flex w-3 bg-gradient-to-t 
                    @if ($submission->compile_feedback)
                        from-red-500 to-red-600
                    @else
                        from-green-500 to-green-400
                    @endif
                    "></div>
                    <div class="flex-1 p-3">
                      <h1 class="md:text-xl text-gray-600">Execution Time</h1>
                      <p class="text-gray-400 text-xs md:text-sm font-light">
                    @if ($submission->compile_feedback)
                          Error Compiling
                    @else
                          {{ round($question->submissions->last()->execution_time,5) }} Sec.
                    @endif
                        </p>
                    </div>
                    <div class="border-l border-gray-100 px-8 flex place-items-center">
                      <p class="text-gray-400 text-xs"><i class="far fa-clock"></i></p>
                    </div>
                </div>
            </div>
           @if(count($question->grading_criteria)>0)
           {{-- Check if grading criteria is set for test cases & that the submission got 0 marks for test cases --}}
                @if ($submission->not_hidden_logic_grade + $submission->hidden_logic_grade == 0 &&
                 $question->grading_criteria->last()->not_hidden_test_cases_weight + $question->grading_criteria->last()->hidden_test_cases_weight > 0)
                    <div class="flex bg-yellow-200 items-center flex-row shadow-md border px-4 py-2 my-4 rounded-lg overflow-hidden w-full mx-2">
                        <h2 class="text-2xl mr-2"><i class="las la-lightbulb"></i> Note:</h2>
                        <p>
                            <div class="hidden modal_contains">
                                <x-failed-test-cases-feedback :question="$question" :submission="$submission" />
                            </div>
                            All of the test cases failed 
                            <span data-modal-title="Wrong output reason" data-modal-close-button="Got It!" class="modal_open py-2 px-8 bg-yellow-300 shadow-md mx-2 hover:bg-yellow-400 rounded-md">See why</span>
                        </p>
                    </div>
                @endif
            @endif
                <pre class="p-8" id="question_{{ $question->id }}"><code>{{  file_get_contents(public_path($question->submissions->last()->submitted_code)) }}</code></pre>
            
            @if ($submission->compile_feedback)
                @php
                    $data = json_decode($question->submissions->last()->compile_feedback);
                @endphp
                @if($data != null)
                <div class=" bg-white w-full shadow rounded-md px-4 py-4">
                    <div class="text-center text-2xl font-bold mb-3">
                        Syntax Errors <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h1 class="text-xl font-bold mt-4">Compiler Feedback:</h1>
                    <pre class=" bg-gray-200 my-5 px-3 py-4 rounded shadow">{!! nl2br(e($data->compiler_feedback)) !!}</pre>
                    @if($data->status == "success")
                    <h1 class="text-xl font-bold mt-4 text-green-600">Evalseer Feedback:</h1>
                    <pre class=" bg-gray-200 my-5 px-3 py-4 rounded shadow">Missing {{ $data->token }} at line {{ $data->line }}</pre>
                    @php
                        $solution = htmlspecialchars($data->solution);
                        $solution = explode("\n",$solution);
                        foreach ($solution as $key =>$sol) {
                            $solution[$key]="<div class='code'>$sol</div>";
                        }
                        $solution[$data->line-1] = "<div class='bg-green-400 text-red-500 highlight-inline'>{$solution[$data->line-1]}</div>";
                        $solution = implode("",$solution);
                    @endphp
                    <pre class="fixed_output bg-gray-200 my-5 rounded shadow ">{!! $solution !!}</pre>
                    @else
                    <div class="bg-gray-200 my-5 px-3 py-4 rounded shadow">
                        <h1 class="text-xl font-bold mt-4 text-red-600">Evalseer Couldn't find any possible solutions:</h1>
                    </div>
                    @endif
                </div>
                @endif
                    
            @endif
            @endif

            @if(count($question->submissions)<$assignment->submissions && $submission_allowed)
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="w-full text-center block py-4">
                        <div class=" justify-center items-center">
                            <label class="table mx-auto bg-text text-white px-10 py-4 rounded-lg font-bold text-sm cursor-pointer">
                            Add Submission for {{ $question->name }}
                            <input accept=".cpp" id="question_file_{{ $question->id }}" type="file" class="hidden" name="submission" >
                        </label>
                            <div id="question_filename_{{ $question->id }}" class="text-gray-500 "></div>
                        </div>
                        
                        <script>
                            var file_input = document.getElementById('question_file_{{ $question->id }}');
                            file_input.addEventListener('change',function(){
                                var value = "File selected";
                                document.getElementById('question_filename_{{ $question->id }}').innerHTML = value;
                            })
                        </script>
                    </div>
                    <div class="w-full text-center block py-4 ">
                        <input type="submit" class=" bg-green-700 hover:bg-green-600 py-4 text-white px-10 rounded-lg font-bold text-sm cursor-pointer"name="submission[]" >
                    </div>
                </form>
            @endif
            </div>
        </div>
        
    </div>
    
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                hljs.highlightElement(el);
            });
        });
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('div.code').forEach((el) => {
                hljs.highlightElement(el);
            });
        });
    </script>
@endsection