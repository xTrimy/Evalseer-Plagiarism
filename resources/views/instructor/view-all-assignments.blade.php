@extends('layout.dashboard.app')
@section('page')
users
@endsection
@section('title')
  View Assignments
@endsection
@section('content')
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <div class="flex justify-between mt-8 items-center">
                
                <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                 Courses Assignments
                </h2>
                <a href="{{ route('dashboard.assignments.add_assignment') }}">
                    <button class="py-2 px-8 text-white rounded-lg bg-orange-600 hover:bg-orange-500 active:bg-orange-400 text-lg ring-0 transition-all active:ring-4 ring-orange-200 dark:ring-orange-800">
                        <i class="las la-plus text-2xl"></i> Add Assignment
                    </button>
                </a>
            </div>
            
            <div class="w-full rounded-lg shadow-xs">
              <div class="w-full flex flex-wrap">
                @foreach ($courses as $course)
                  <div class="w-30 text-center mx-3 my-3 rounded-xl shadow bg-white relative overflow-hidden">
                    <span
                      class="absolute inset-x-0 bottom-0 h-2  bg-gradient-to-r from-gray-400 to-gray-700">
                    </span>
                    <div class="w-30 h-72">
                      <img src="{{ asset('png/23.jpg') }}" class="w-full h-64 rounded-tr-xl rounded-tl-xl" width="100%" alt="">
                    </div>
                    <div class="p-2 px-4">
                      <div class="flex items-center mb-3">
                        <h1 class="text-center">{{ $course->name }}</h1>
                        <div class="flex-1 text-right">
                            <span class="text-sm px-2 bg-green-100 text-green-600 rounded-full">Active</span>
                        </div> 
                      </div>
                      <hr class="my-2">
                        <dl class="flex mt-6 justify-center mb-3">
                          <div class="flex flex-col-reverse">
                            <dt class="text-sm font-medium text-gray-600">{{$assignment_count[$course->id]}}</dt>
                            <dd class="text-xs text-gray-500">Assignments</dd>
                          </div>

                          <div class="flex flex-col-reverse ml-3 sm:ml-6">
                            <dt class="text-sm font-medium text-gray-600">{{$submission_count[$course->id]}}</dt>
                            <dd class="text-xs text-gray-500">Submissions</dd>
                          </div>

                          <div class="flex flex-col-reverse ml-3 sm:ml-6">
                            <dt class="text-sm font-medium text-gray-600">{{$student_count[$course->id]}}</dt>
                            <dd class="text-xs text-gray-500">Students</dd>
                          </div>
                        </dl>
                    </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </main>
        <script type="text/javascript">
          function openModal(modalId) {
            modal = document.getElementById(modalId)
            modal.classList.remove('hidden')
          }
          
          function closeModal(modalId) {
            modal = document.getElementById(modalId)
            modal.classList.add('hidden')
          }
          </script>
@endsection