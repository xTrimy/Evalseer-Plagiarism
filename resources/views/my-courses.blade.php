<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Courses | CS101</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://kit.fontawesome.com/b1361fb5d5.js" crossorigin="anonymous"></script>
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
            <p class="text-white font-bold cursor-pointer mr-6">HOME</p>
            <p class="text-white font-bold cursor-pointer mr-6">EDUCATION</p>
            <p class="text-white font-bold cursor-pointer mr-6">CATALOG</p>
            <p class="text-white font-bold cursor-pointer mr-6">OPPORTUNITIES</p>
            <p class="text-white font-bold cursor-pointer mr-6">COURSES</p>
            <p class="text-white font-bold cursor-pointer mr-6">ACHIEVMENTS</p>
            <p class="text-white font-bold cursor-pointer mr-6">HOW IT WORKS</p>
        </div>
        <div class="flex w-96 py-8 bg-text text-center justify-center">
            <p class="text-white font-bold text-center cursor-pointer">LOGOUT</p>
        </div>
    </div>
    <div class="w-full bg-text py-1"></div>
    <div class="flex w-full">
        <div class="flex w-full px-32 py-2 bg-gray-900">
            <p class="text-white font-bold cursor-pointer mr-6">CS101: FUNDAMENTALS OF COMPUTER PROGRAMMING</p>
        </div>
    </div>
    <div class="flex w-full">
        <div class="flex w-full px-32 py-4 bg-white">
            <p class="text-gray-900 font-bold cursor-pointer">Home > My Courses > <p class="text-text font-bold">CS101: Fundamentals of computer programming</p></p>
        </div>
    </div>
    <div class="flex w-full mb-8">
        <div class="flex w-full px-32 py-4 bg-gray-200">
            <div class="bg-red-800 rounded-lg px-8 py-5 text-center mr-5 w-40">
                <i class="fab fa-buromobelexperte text-white text-center text-2xl"></i>
                <p class="font-bold text-white">Dashboard</p>
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
    <div class="flex w-full">
        <div class="w-full px-32 py-4 bg-white box-border">
            <h1 class="font-bold text-2xl mb-10">My Courses</h1>
            <div class="flex flex-wrap text-center w-4/5 m-auto justify-center box-border">
                <style>
                    .course {
                        background-image: url('/public/png/23.jpg');
                    }

                    .w-30 {
                        width: 30%;
                    }
                </style>
                @foreach ($courses as $course)
                    <div class="relative w-30 h-72 text-center mx-3 rounded-xl shadow">
                        <img src="{{ asset('png/23.jpg') }}" class="rounded-xl w-full h-full" alt="">
                        <div class="absolute course w-11/12 mx-4 my-3 m-auto rounded-xl text-center box-border top-0">
                            <div class=" h-32"></div>
                            <div class="bg-gradient-to-r from-gray-400 to-gray-700 w-full m-auto rounded-lg flex justify-center text-white py-2 px-6 mb-4">
                                {{ $course->course_id }}:{{ $course->name }}
                            </div>
                            <div class="w-full text-center">
                                <a href="{{ route('course.view',$course->id) }}">
                                    <div  class=" bg-text text-white px-10 py-3 rounded-lg font-medium text-sm cursor-pointer mb-6">
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
</body>
</html>
