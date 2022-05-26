@extends('layout.app')
@section('title')
{{ $course->course_id }} Assignments
@endsection
@section('course_title')
{{ $course->name }}
@endsection
@section('page_title')
{{ $course->name }}
@endsection
@section('content')
    <div class="flex w-full">
        <div class="w-full px-32 py-4 bg-white">
            <div class="flex-1 flex px-12 py-2 bg-green-600 rounded-3xl mr-10 items-center mb-10 relative" id="assignments">
                <div class=" mr-8">
                    <img src="{{ asset('png/book.png') }}" width="80" alt="">
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-left font-bold text-white text-3xl">Assignements</p>
                </div>
            </div>
            @php
            $i = 0;
            @endphp
            @foreach ($course->assignments as $assignment)
            <div id="assignment" class="relative">
                <a href="{{ route('assignment',$assignment->id) }}">
                    <div class="flex-1 flex px-12 py-8 bg-gray-200 rounded-3xl mr-10 items-center  mb-8">
                        <div class="mr-12">
                            <i class="fas fa-book text-green-600 text-4xl"></i>
                        </div>
                        <div class="text-center w-full">
                            <p class="w-full text-left font-bold text-xl">{{ $assignment->name }}</p>
                            <p class="text-left font-bold text-xl">Opened: <span class="text-left font-normal">{{ $assignment->start_time->format('l, d F, H:i A') }}</span> </p>
                            <p class="w-full text-left font-bold text-xl">Due: <span class="text-left font-normal">{{ $assignment->end_time->format('l, d F, H:i A') }}</span></p>
                        </div>
                    </div> 
                </a>
            </div>
            @endforeach
           
        </div>
    </div>

    <div class="flex w-full">

    </div>
    <ol id="tour" data-cookie="assignments_tour" class="hidden">
        <li data-id="assignments" data-position="bottom-full">This is a list of the assignments available for this course.</li>
        <li data-id="assignment" data-position="bottom-full">Enter any of the assignments to start solving it.</li>
    </ol>
    <script>
        window.onload = function(){
            tour(document.getElementById('tour'));
            start_tour();
        };
    </script>
@endsection