<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course | CS101</title>
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
        <div class="w-full px-32 py-4 bg-white">
            <div class="flex-1 flex px-12 py-2 bg-green-600 rounded-3xl mr-10 items-center mb-10">
                <div class=" mr-8">
                    <img src="{{ asset('png/book.png') }}" width="80" alt="">
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-left font-bold text-white text-3xl">Assignements</p>
                </div>
            </div>
            <div class="flex-1 flex px-12 py-8 bg-gray-200 rounded-3xl mr-10 items-center cursor-pointer mb-8">
                <div class="mr-12">
                    <i class="fas fa-book text-green-600 text-4xl"></i>
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-left font-bold text-xl">Lab 1 Assignment (Wednesday)</p>
                    <p class="text-left font-bold text-xl">Opened: <span class="text-left font-normal">Wednesday, 6 October 2021, 8:30 AM</span> </p>
                    <p class="w-full text-left font-bold text-xl">Due: <span class="text-left font-normal">Wednesday, 6 October 2021, 12:30 PM</span></p>
                </div>
            </div>
            <div class="flex-1 flex px-12 py-8 bg-gray-200 rounded-3xl mr-10 items-center cursor-pointer mb-8">
                <div class="mr-12">
                    <i class="fas fa-book text-green-600 text-4xl"></i>
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-left font-bold text-xl">Lab 2 Assignment (Wednesday)</p>
                    <p class="text-left font-bold text-xl">Opened: <span class="text-left font-normal">Wednesday, 6 October 2021, 8:30 AM</span> </p>
                    <p class="w-full text-left font-bold text-xl">Due: <span class="text-left font-normal">Wednesday, 6 October 2021, 12:30 PM</span></p>
                </div>
            </div>
            <div class="flex-1 flex px-12 py-8 bg-gray-200 rounded-3xl mr-10 items-center cursor-pointer mb-8">
                <div class="mr-12">
                    <i class="fas fa-book text-green-600 text-4xl"></i>
                </div>
                <div class="text-center w-full">
                    <p class="w-full text-left font-bold text-xl">Lab 3 Assignment (Wednesday)</p>
                    <p class="text-left font-bold text-xl">Opened: <span class="text-left font-normal">Wednesday, 6 October 2021, 8:30 AM</span> </p>
                    <p class="w-full text-left font-bold text-xl">Due: <span class="text-left font-normal">Wednesday, 6 October 2021, 12:30 PM</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex w-full">

    </div>
</body>
</html>
