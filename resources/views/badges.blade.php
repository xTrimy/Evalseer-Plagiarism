@extends('layout.app')
@section('title')
Badges
@endsection
@section('content')
    <div class="flex w-3/4 m-auto">
        <div class="w-1/4 shadow bg-white h-full rounded-md p-3 mb-10">
            <div class="h-52 w-full mb-4">
                <img class="rounded-lg h-full w-full object-cover" src="{{ asset('uploadedimages/'.($user->image??'user.png')) }}" alt="">
            </div>
            <p class=" font-bold text-lg">{{ $user->name }}</p>
            <p class=" font-light text-base text-gray-500">Student</p>
            <hr class="my-5">
            <div class="mb-3">
                <p class=" font-light text-base text-gray-500">Current Title</p>
                <p class=" font-bold text-lg">{{ $rank_name->name??"N/A" }}</p>
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
                <button id="show_owned_only_button" type="button" data-active="true"
                   class="flex items-center w-full justify-between px-5 py-3 text-sm mb-4 font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange"
                >
                <div id="owned_circle" class="w-6 h-6 bg-white border-2 border-solid border-white rounded-full"></div>
                    <span class="uppercase">Show all badges</span>
            </button>
            </div>
                <div id="owned_badges">
                        
                    @php
                        $owned = 0;
                    @endphp
                    @foreach ($all_badges as $badge)
                        @php
                            $level = count($badge->user_badges);
                            $max_level = 5;
                            if($level != $max_level)
                                continue;
                            $owned++;
                            $current_level = $level/$max_level * 100;
                        @endphp
                    <div class="w-1/4 bg-white shadow-md rounded-lg text-center p-4">
                        <div class="w-3/4 m-auto">
                            <img src="{{ asset($badge->icon) }}" alt="">
                        </div>
                        <p class="font-bold my-3">{{$badge->name}}</p>
                        <div class="relative h-6 text-white rounded-3xl overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-full bg-gray-400"></div>
                           
                        <div style="width:{{$current_level}}%" class=" absolute top-0 left-0 bg-text h-full "></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">{{$level}}/{{$max_level}}</div>
                        </div>
                        </div>
                    @endforeach
                    @if ($owned == 0)
                    <div class="text-center w-full font-bold text-2xl mt-6 px-5 py-12 bg-red-100 rounded">
                        No Badges To Show
                    </div>
                    @endif
                </div>
                <div id="all_badges" class="hidden flex flex-wrap">
                    @foreach ($all_badges as $badge)
                    @php
                        $level = count($badge->user_badges);
                        $max_level = 5;
                        $current_level = $level/$max_level * 100;
                    @endphp
                    <div class="w-1/4 bg-white shadow-md rounded-lg text-center p-4">
                        <div class="w-3/4 m-auto">
                            <img class="{{$level!=$max_level?"grayscale":""}}" src="{{ asset($badge->icon) }}" alt="">
                        </div>
                        <p class="font-bold my-3">{{$badge->name}}</p>
                        <div class="relative h-6 text-white rounded-3xl overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-full bg-gray-400"></div>
                            
                        <div style="width:{{$current_level}}%" class=" absolute top-0 left-0 bg-text h-full "></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">{{$level}}/{{$max_level}}</div>
                        </div>
                        </div>
                    @endforeach
                    
                </div>
                
        </div>
    </div>

    <script>
        let show_owned_only_button = document.getElementById('show_owned_only_button');
        let all_badges = document.getElementById('all_badges');
        let owned_badges = document.getElementById('owned_badges');

        show_owned_only_button.addEventListener('click',function(){
            if(this.getAttribute('data-active') == "true"){
                all_badges.classList.remove('hidden');
                owned_badges.classList.add('hidden');
                this.setAttribute('data-active','false');
                this.querySelector('#owned_circle').classList.remove('bg-white');
                this.querySelector('span').innerHTML = "Show owned only";
            }else{
                all_badges.classList.add('hidden');
                owned_badges.classList.remove('hidden');
                this.setAttribute('data-active','true');
                this.querySelector('#owned_circle').classList.add('bg-white');
                this.querySelector('span').innerHTML = "Show all badges";
            }
        });
    </script>
@endsection