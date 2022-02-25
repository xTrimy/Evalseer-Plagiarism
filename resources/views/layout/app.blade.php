<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/b1361fb5d5.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div class="flex w-full px-8 py-5">
        <div class="flex-1  text-center flex justify-center">
            <div class="w-3/4">
                <img class="ml-8" src="{{ asset('png/logo.png') }}" width="100" alt="">
            </div>
            
        </div>
        <div class="flex-1 w-full flex items-center justify-center text-center font-bold">
            <div class="flex">
                <div class="text-right mr-4 cursor-pointer text-lg">ABOUT US</div>
                <div class="text-right cursor-pointer text-lg">CONTACT US</div>
            </div>
        </div>
    </div>

    <div class="flex w-full">
        <div class="flex w-full px-32 py-8 bg-gray-900">
            <a href="{{ route('home') }}">
                <p class="text-white font-bold cursor-pointer mr-6">HOME</p>
            </a>
            <a href="/dashboard/">
                <p class="text-white font-bold cursor-pointer mr-6">DASHBOARD</p>
            </a>
            {{-- <p class="text-white font-bold cursor-pointer mr-6">EDUCATION</p>
            <p class="text-white font-bold cursor-pointer mr-6">CATALOG</p>
            <p class="text-white font-bold cursor-pointer mr-6">OPPORTUNITIES</p>
            <p class="text-white font-bold cursor-pointer mr-6">COURSES</p>
            <p class="text-white font-bold cursor-pointer mr-6">ACHIEVMENTS</p>
            <p class="text-white font-bold cursor-pointer mr-6">HOW IT WORKS</p> --}}
        </div>
        <div class="flex w-96 py-8 bg-text text-center justify-center">
            <p class="text-white font-bold text-center cursor-pointer">LOGOUT</p>
        </div>
    </div>
    <div class="w-full bg-text py-1"></div>
    <div class="flex w-full">
        <div class="flex w-full px-32 py-2 bg-gray-900">
            <p class="text-white font-bold cursor-pointer mr-6">Title</p>
        </div>
    </div>
    <div class="flex w-full">
        <div class="flex w-full px-32 py-4 bg-white">
            <p class="text-gray-900 font-bold cursor-pointer">Home > My Courses > <p class="text-text font-bold">Title</p></p>
        </div>
    </div>
    <div class="flex w-full mb-8">
        <div class="flex w-full px-32 py-4 bg-gray-200">
            <div class="bg-red-800 rounded-lg px-8 py-5 text-center mr-5 w-40">
                <i class="fab fa-buromobelexperte text-white text-center text-2xl"></i>
                <p class="font-bold text-white">Dashboard </p>
            </div>
            <div class="bg-green-600 rounded-lg px-8 py-5 text-center mr-5 w-40">
                <i class="far fa-calendar text-white text-center text-2xl"></i>
                <p class="font-bold text-white">Calendar</p>
            </div>
            <div class="bg-orange-500 rounded-lg px-8 py-5 text-center mr-5 w-40">
                <i class="fas fa-certificate text-white text-center text-2xl"></i>
                <p class="font-bold text-white">Badges</p>
            </div>
            <div class="bg-blue-500 rounded-lg px-8 py-5 text-center mr-5 w-40">
                <i class="fas fa-book text-white text-center text-2xl"></i>
                <p class="font-bold text-white">All Courses</p>
            </div>
        </div>
    </div>
    @yield('content')
    </body>
</html>
