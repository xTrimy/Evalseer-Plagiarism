@extends('layout.app')
@section('title')
{{ $course->name }}
@endsection
@section('course_title')
{{ $course->name }}
@endsection
@section('page_title')
{{ $course->name }}
@endsection
@section('content')
    <div class="flex w-full">
        <div class="flex w-full px-32 py-4 bg-white">
            <div class="mr-10 flex-1 relative" id="assignments">
                <a href="{{ route('course.assignments',$course->id) }}">
                    <div class="flex-1 flex px-12 py-4 bg-green-600 rounded-2xl items-center cursor-pointer">
                        <div>
                            <img src="{{ asset('png/book.png') }}" width="120" alt="">
                        </div>
                        <div class="text-center w-full">
                            <p class="w-full text-center font-bold text-white text-3xl">Assignements</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="flex-1 flex px-12 py-4 bg-blue-500 rounded-2xl items-center cursor-pointer">
                <div>
                    <img src="{{ asset('png/open-book.png') }}" width="120" alt="">
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-center font-bold text-white text-3xl">Quizzes</p>
                </div>
            </div>
        </div>
    </div>
    <ol id="tour" data-cookie="course_tour" class="hidden">
        <li data-id="assignments" data-position="bottom-full">You can access the course assignments here</li>
    </ol>
    <script>
        window.onload = function(){
            tour(document.getElementById('tour'));
            start_tour();
        };
    </script>
@endsection