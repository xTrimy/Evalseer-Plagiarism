@extends('layout.app')
@section('title')
My Courses
@endsection

@section('content')
    <div class="flex w-full">
        <div class="w-full px-32 py-4 bg-white box-border">
            <h1 class="font-bold text-2xl mb-10">My Courses</h1>
            <div id="courses" class="relative flex flex-wrap text-center w-4/5 m-auto justify-center box-border">
                <style>
                    .course {
                        background-image: url('/public/png/23.jpg');
                    }

                    .w-30 {
                        width: 30%;
                    }
                </style>
                @php
                    $i=0;
                @endphp
                @foreach ($courses as $course)
                    <div class="relative w-30 h-72 text-center mx-3 rounded-xl shadow">
                        <img src="{{ asset('png/23.jpg') }}" class="rounded-xl w-full h-full" alt="">
                        <div class="absolute course w-11/12 mx-4 my-3 m-auto rounded-xl text-center box-border top-0">
                            <div class=" h-32"></div>
                            <div class="bg-gradient-to-r from-gray-400 to-gray-700 w-full m-auto rounded-lg flex justify-center text-white py-2 px-6 mb-4">
                                {{ $course->course_id }}:{{ $course->name }}
                            </div>
                            <div @if($i++ == 0) id="enter_course" @endif  class="relative w-full text-center">
                                <a href="{{ route('course.view',$course->id) }}">
                                    <div
                                     class=" bg-text text-white px-10 py-3 rounded-lg font-medium text-sm cursor-pointer mb-6">
                                        ENTER THE COURSE
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                
            </div>
        </div>
    </div>
    <ol id="tour" data-cookie="my_courses_tour" class="hidden">
        <li data-id="courses" data-position="bottom-full">This is your courses, you can access any of them</li>
        <li data-id="enter_course">Click here to enter course</li>
    </ol>
    <script>
        window.onload = function(){
            tour(document.getElementById('tour'));
            start_tour();
        };
    </script>
@endsection