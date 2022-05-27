@extends('layout.app')
@section('title')
My Courses
@endsection

@section('content')
    <div class="w-full">
        <div class=" w-9/12 m-auto">
        @if(Session::has('success'))
            <div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
                <div class="flex items-center"> <i class="fas fa-check mr-2"></i> <span>{{ Session::get('success') }}</span> </div>
            </div> 
        @endif
        @if(Session::has('error'))
            <div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-red-600 bg-red-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
                <div class="flex items-center"> <i class="las la-xmark"></i> <span>{{ Session::get('error') }}</span> </div>
            </div> 
        @endif
        </div>
        
        <div class="w-1/4 m-auto text-center px-5 py-4 shadow-lg rounded-md my-20">
           <b> {{ $course->course_id }}</b>:{{ $course->name }}
           <hr class="my-3">
           <p class="text-left mb-3">Enter The <i>Access Code </i> For This Course To Enroll In It.</p>
           <p class="text-left mb-5">You can ask your instructor about the access code if you don't have it.</p>
            <form method="POST">
                @csrf
                <input type="text" name="access_code" placeholder="Enter The Access Code" class=" w-full bg-gray-100 py-2 text-black outline-none px-4 rounded-md mb-6">
                <input type="submit" class="w-full bg-text py-3 outline-none px-8 rounded-md mb-6 text-white font-bold text-xl cursor-pointer" value="Enroll">
            </form>
        </div>  
    </div>
@endsection