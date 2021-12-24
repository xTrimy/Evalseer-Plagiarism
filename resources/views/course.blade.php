@extends('layout.app')
@section('title')
{{ $course->name }}
@endsection
@section('content')
    <div class="flex w-full">
        <div class="flex w-full px-32 py-4 bg-white">
            <div class="flex-1 flex px-12 py-4 bg-green-600 rounded-2xl mr-10 items-center cursor-pointer">
                <div>
                    <img src="{{ asset('png/book.png') }}" width="120" alt="">
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-center font-bold text-white text-3xl">Assignements</p>
                </div>
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
@endsection