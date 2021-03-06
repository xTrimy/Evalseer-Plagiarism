@extends('layout.registration')
@section('title')
Login
@endsection
@section('content')
        <div class="w-full p-10">
            
            <form method="POST" class="xl:w-2/4 w-full h-8 m-auto mt-20">
                @csrf
                @if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
            @if(Session::has('status'))
                <div class="text-red-500">{{ Session::get('status') }}</div>
            @endif
                <div class=" bg-blue-500 w-full px-3 py-2 shadow-md rounded-sm text-white mb-5">
                    <h1 class="font-bold my-2">Login Instructions</h1>
                    <hr class="my-2">
                    <p class="font-bold">Example:  </p>
                    <p>Email Address: <span class="font-bold">abdelrahman1814541@miuegypt.edu.eg</span> </p>   
                    <p class=" mb-3">Password: <span class="font-bold">abdelrahman1814541</span> </p>
                    <p>Note: <span class="font-bold">Use Lowercase Characters</span> </p>  
                </div>
                <h1 class=" text-3xl font-bold mb-4">Sign In</h1>
                {{-- <div class="w-full shadow py-5 text-center font-bold text-xl mb-5 cursor-pointer flex px-4">
                    <div>
                        <img src="{{ asset('png/google.png') }}" class=" mr-1" width="30" alt="">
                    </div>
                    <p class="w-full text-center">Sign In With Google</p> 
                </div> --}}
                <hr class=" my-5">
                <h1 class=" text-2xl font-bold mb-4">Email Address </h1>
                <input type="email" name="email" placeholder="Enter Your Email" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-6">
                <h1 class=" text-2xl font-bold mb-4">Password</h1>
                <input type="password" name="password" placeholder="Enter Your Password" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-16">
                <input type="submit" class="w-full bg-text py-6 outline-none px-8 rounded-md mb-6 text-white font-bold text-xl cursor-pointer" value="Sign In">
                {{-- <p class="text-center"><a href="#" class="text-center text-text font-bold text-xl">Forgot Password?</a></p> --}}
            </form>
        </div>
@endsection