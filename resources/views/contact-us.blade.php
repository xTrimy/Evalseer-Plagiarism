@extends('layout.app')
@section('title')
My Courses
@endsection

@section('content')
    <div class="w-full">
        <div class="w-3/5 m-auto shadow-md rounded-lg px-7 py-5 my-14">
            @if(Session::has('success'))
                <div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
                    <div class="flex items-center"> <i class="fas fa-check mr-2"></i> <span>{{ Session::get('success') }}</span> </div>
                </div> 
            @endif
            <div class="w-full px-3 mb-6 md:mb-0">
                <form method="POST">
                    @csrf
                    <h1 class="text-center font-bold text-2xl mb-10">Contact Us</h1>
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                        Name
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-6 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 outline-0" id="grid-first-name" type="text" placeholder="Your Name" name="name">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror

                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                        Email
                    </label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-6 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 outline-0" id="grid-first-name" type="email" placeholder="Your Email" name="email">
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror

                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                        Message
                    </label>
                    <textarea name="message" id="message" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-6 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 outline-0" cols="30" rows="10"></textarea>
                    @error('message')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror

                    <input type="submit" class="w-full bg-text py-3 outline-none px-8 rounded-md mb-6 text-white font-bold text-xl cursor-pointer" value="Send Message">
                </form>
            </div>
        </div>
    </div>
@endsection