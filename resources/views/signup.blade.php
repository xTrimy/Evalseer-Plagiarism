<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <div class="flex">
        <div class="flex h-screen items-center">
            <div class="m-auto">
                <div class="text-2xl my-16 w-40 text-center py-7 font-bold">
                    Sign in
                </div>
                <div class="text-text text-2xl my-16 border-l-2 border-primary w-40 text-center py-7 font-bold">
                    Sign Up
                </div>
            </div>
        </div>
        <div class="bg-primary flex items-center px-28">
            <div>
                <img src="{{ asset('png/logo.png') }}" width="180" alt="logo">
            </div>
        </div>
        <div class="w-full p-10">
            <div class="w-2/4 h-8 m-auto mt-4">
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
    </div>
</body>
</html>
