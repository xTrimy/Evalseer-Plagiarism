@extends('layout.app')
@section('title')
{{ $assignment->name }}
@endsection
@section('content')
@if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
    <div class="flex w-full">
            <div class="w-3/4 p-8 bg-gray-200 m-auto rounded-3xl ">
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
    <div class="w-3/4 mx-auto">
        <div class="w-full py-8 text-left">
            <div class="bg-gray-200 rounded-lg p-8">
            @if(Session::has('question_'.$question->id))
            <div class="w-full py-4 px-8 text-green-700 bg-green-300">
                {{ Session::get('question_'.$question->id) }}
            </div>
            @endif
            <h1 class="text-gray-800 text-2xl p-2 bg-gray-300 font-bold">Question: {{ $question->name }}</h1>
            <p class="text-gray-800 text-lg p-2 bg-gray-300 ">Description: {{ $question->description }}</p>
            <p class="text-gray-800 text-lg p-2 bg-gray-300 ">Status: 
                @if(count($question->submissions)>0)
                <i class="las la-check text-xl text-green-500"></i> Submitted at {{ $question->submissions->last()->created_at->format('l, d F, H:i A') }}
                @else
                <i class="las la-times text-xl text-red-500"></i> Not Submitted

                @endif
            </p>
            @if(count($question->submissions)>0)
            <p>{{ $question->submissions->last()->logic_feedback }} </p>
                <pre class="p-8" id="question_{{ $question->id }}"><code>{!!  file_get_contents(public_path($question->submissions->last()->submitted_code)) !!}</code></pre>
            
            @endif
            @if(count($question->submissions)<$assignment->submissions)
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="w-full text-center block py-4">
                        <label class=" bg-text text-white px-10 py-4 rounded-lg font-bold text-sm cursor-pointer">
                            Add Submission for {{ $question->name }}
                            <input type="file" class="hidden" name="submission" >
                        </label>
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