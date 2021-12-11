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
                <div class="text-text text-2xl my-16 border-l-2 border-primary w-40 text-center py-7 font-bold">
                    Sign in
                </div>
                <div class="text-2xl my-16 w-40 text-center py-7 font-bold">
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
            <div class="w-2/4 h-8 m-auto mt-20">
                <h1 class=" text-3xl font-bold mb-4">Sign In</h1>
                <div class="w-full shadow py-5 text-center font-bold text-xl mb-5 cursor-pointer flex px-4">
                    <div>
                        <img src="{{ asset('png/google.png') }}" class=" mr-1" width="30" alt="">
                    </div>
                    
                    <p class="w-full text-center">Sign In With Google</p> 
                </div>
                <hr class=" my-5">
                <h1 class=" text-2xl font-bold mb-4">Email Address</h1>
                <input type="email" placeholder="Enter Your Email" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-6">
                <h1 class=" text-2xl font-bold mb-4">Password</h1>
                <input type="password" placeholder="Enter Your Password" class=" w-full bg-gray-100 py-6 text-black outline-none px-8 rounded-md mb-16">
                <input type="submit" class="w-full bg-text py-6 outline-none px-8 rounded-md mb-6 text-white font-bold text-xl cursor-pointer" value="Sign In">
                <p class="text-center"><a href="#" class="text-center text-text font-bold text-xl">Forgot Password?</a></p>
            </div>
        </div>
    </div>
</body>
</html>
