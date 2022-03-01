@extends('layout.registration')
@section('title')
Signup
@endsection
@section('content')
        <div class="w-full p-10">
            @if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
            <div class="xl:w-2/4 h-8 m-auto mt-4">
                <form action="{{ route('createUser') }}" method="POST">
                    @csrf
                    <h1 class=" text-3xl font-bold mb-4">Sign Up</h1>
                    <hr class=" my-5">
                    <h1 class=" text-2xl font-bold mb-4">Full Name</h1>
                    <input type="text" name="name" placeholder="Enter Your Full Name" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-6">
                    <h1 class=" text-2xl font-bold mb-4">Username</h1>
                    <input type="text" name="username" placeholder="Enter Your Username" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-6">
                    <h1 class=" text-2xl font-bold mb-4">Email Address</h1>
                    <input type="email" name="email" placeholder="Enter Your Email" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-6">
                    <h1 class=" text-2xl font-bold mb-4">Password</h1>
                    <input type="password" name="password" placeholder="Enter Your Password" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-6">
                    <h1 class=" text-2xl font-bold mb-4">Confirm Password</h1>
                    <input type="password" name="password_confirmed" placeholder="Enter Your Password" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-8">
                    <input type="submit" name="submit" class="w-full bg-text py-6 outline-none px-8 rounded-md mb-6 text-white font-bold text-xl cursor-pointer" value="Sign Up">
                </form>
            </div>
        </div>
@endsection
