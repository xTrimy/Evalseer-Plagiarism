@extends('layout.app')
@section('title')
Badges
@endsection
@section('content')
    <div class="flex w-3/4 m-auto">
        <div class="w-1/4 shadow bg-white h-full rounded-md p-3 mb-10">
            <div class="h-52 w-full mb-4">
                <img class="rounded-lg h-full w-full object-cover" src="{{ asset('uploadedimages/'.$user->image) }}" alt="">
            </div>
            <p class=" font-bold text-lg">{{ $user->name }}</p>
            <p class=" font-light text-base text-gray-500">Student</p>
            <hr class="my-5">
            <div class="mb-3">
                <p class=" font-light text-base text-gray-500">Current Title</p>
                <p class=" font-bold text-lg">{{ $rank_name->name }}</p>
            </div>
            <div class="mb-3">
                <p class=" font-light text-base text-gray-500">Number Of Logins</p>
                <p class=" font-bold text-lg">{{ $user->number_of_logins }}</p>
            </div>
            <div class="mb-3">
                <p class=" font-light text-base text-gray-500">Score</p>
                <p class=" font-bold text-lg">{{ $user->reputation }}</p>
            </div>
            <div class="mb-3">
                <p class=" font-light text-base text-gray-500">Number Of Opened Badges</p>
                <p class=" font-bold text-lg">{{ $badges_opened }}</p>
            </div>
            <div class="mb-3">
                <p class=" font-light text-base text-gray-500">Number Of Closed Badges</p>
                <p class=" font-bold text-lg">{{ $badges_closed }}</p>
            </div>
        </div>
        
        <div class=" h-full rounded-md p-5 mb-10 w-full">
            <div class="w-60">
                <a href=""
                   class="flex items-center w-full justify-between px-5 py-3 text-sm mb-4 font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange"
                >
                <i class="mr-2 fas fa-circle-notch text-xl"></i>
                    SHOW OWNED ONLY
                </a>
            </div>
           
                @if ($badges_opened == 0)
                    <div class="text-center w-full font-bold text-2xl mt-6 px-5 py-12 bg-red-100 rounded">
                        No Badges Till Now
                    </div>
                @else
                    <div class=" flex flex-wrap">
                        <div class="w-1/4 bg-white shadow-md rounded-lg text-center p-4">
                            <div class="w-3/4 m-auto">
                                <img src="{{ asset('png/Early_Bird.png') }}" alt="">
                            </div>
                            <p class="font-bold my-3">EARLY BIRD</p>
                            <div class="w-full bg-text h-6 rounded-3xl text-white">5/2</div>
                        </div>
                    </div>
                @endif
                
        </div>
    </div>
</body>
</html>
@endsection