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
                                <tr class="mb-8 bg-gray-300 ">
                                    <td class="font-bold text-xl pr-12 py-4 px-3">Submission status</td>
                                    <td class="text-xl">No attempt</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Grade</td>
                                    <td class="text-xl">Not graded</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Time remaining</td>
                                    {{-- <td class="text-xl text-red-800">Assignment is overdue by: 53 days 18 hours</td> --}}
                                    <td class="text-xl ">{{ $assignment->end_time->diffForHumans() }}</td>
                                </tr>
                                <tr class=" h-4"></tr>
                                <tr class="bg-gray-300">
                                    <td class="font-bold text-xl pr-12  py-4 px-3">Last modified</td>
                                    <td class="text-xl">-</td>
                                </tr>
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
            <div class="w-full py-4 px-8 text-green-700 bg-green-300 mb-4 rounded-md shadow flex">
                <div class="flex-1">
                    {{ Session::get('question_'.$question->id) }}
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

            
                <pre class="p-8" id="question_{{ $question->id }}"><code>{{  file_get_contents(public_path($question->submissions->last()->submitted_code)) }}</code></pre>
            
            @if ($submission->compile_feedback)
                <div class=" bg-white w-full shadow rounded-md px-4 py-4">
                    <div class="text-center text-2xl font-bold mb-3">
                        Syntax Errors <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <pre class=" bg-gray-200 my-5 px-3 py-4 rounded shadow">{{ $question->submissions->last()->compile_feedback }}</pre>
                </div>
            @else
                    
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
                            <input accept=".cpp" id="mmm" type="file" class="hidden" name="submission" >
                        </label>
                            <div id="x" class="text-gray-500 "></div>
                        </div>
                        
                        <script>
                            var file_input = document.getElementById('mmm');
                            file_input.addEventListener('change',function(){
                                var value = file_input.value.split('\\')[2];
                                document.getElementById('x').innerHTML = value;
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
    </script>
@endsection