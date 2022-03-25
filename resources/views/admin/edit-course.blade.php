@extends('layout.dashboard.app')
@section('page')
edit-course
@endsection
@section('title')
Edit Course
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Edit Course
            </h2>
            
            @if(Session::has('success'))
            <div
              class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange"
            >
              <div class="flex items-center">
                <i class="fas fa-check mr-2"></i>
                <span>{{ Session::get('success') }}</span>
              </div>
            </div>
            @endif
            <!-- General elements -->
            <form method="POST" enctype="multipart/form-data"
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
            @csrf
            @if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
            <input type="hidden" name="course_id" value="{{ $course->id }}">
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Course Title
                </span>
                <input
                value="{{ $course->name }}"
                type="text"
                name="name"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Title"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Course Code
                </span>
                <input
                value="{{ $course->course_id }}"
                type="text"
                name="course_code"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Course Code"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Credit Hours
                </span>
                <input
                value="{{ $course->credit_hours }}"
                type="number"
                name="credit_hours"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Credit Hours"
                />
              </label>
              
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-marker text-xl"></i>
                Grade
                </span>
                <input
                value="{{ $course->grade }}"
                type="number"
                name="grade"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Grade"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-graduation text-xl"></i>
                Minimum Grade To Pass
                </span>
                <input
                value="{{ $course->grade_to_pass }}"
                type="number"
                name="grade_to_pass"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Minimum Grade To Pass"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Course Start Date
                </span>
                <input
                value="{{ $course->start_date }}"
                type="date"
                name="start_date"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Course Start Date"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Course End Date
                </span>
                <input
                value="{{ $course->end_date }}"
                type="date"
                name="end_date"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Course End Date"
                />
              </label>
              <div class="block text-sm my-4">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-code text-xl"></i>
                Programming Languages
                </span>
                <div class="flex flex-wrap">
                  @foreach ($programming_languages as $lang)
                  <label class="mr-4 dark:text-gray-400 text-gray-700">
                    <input
                    type="checkbox"
                    value="{{ $lang->id }}"
                    name="programming_languages[]"
                    />
                    {{ $lang->name }}
                  </label>
                  @endforeach
                  
                </div>
              </div>
              <div class="flex">
                <div class="form-check form-switch">
                  <input class="form-check-input appearance-none w-9 rounded-full float-left outline-none h-6 align-top bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm outline-0 mr-2" type="checkbox" name="active" role="switch" id="flexSwitchCheckDefault" 
                  @php
                    if($course->active == 1) { echo 'checked'; }
                  @endphp>
                  <label class="form-check-label inline-block text-gray-800 outline-none" for="flexSwitchCheckDefault">Active</label>
                </div>
              </div>
              <button type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
              Edit
              <span class="ml-2" aria-hidden="true">
                  <i class='las la-arrow-right'></i>
              </span>
            </button>
        </form>

          </div>
        </main>
        <script>
          let end_time_el = document.getElementById('end_time');
          let late_time_el = document.getElementById('late_time');
          end_time_el.addEventListener('change',function(){
            late_time_el.value = this.value;
          });
          let course_el = document.getElementById('course');
          let groups_el = document.getElementById('groups');
          course_el.addEventListener('change',function(){
            const val = this.value;
            const api = "/api/course/"+val+"/groups";
            $.ajax({url: api, 
              success: function(result) {
                const groups = result["groups"];
                groups_el.innerHTML = "<option value='' selected disabled>Select a group to assign</option>";
                groups_el.innerHTML += "<option value='' >All Groups</option>";
                for(let i = 0; i<groups.length; i++){
                  const group = groups[i];
                  let option = document.createElement('option');
                  option.value = group["id"];
                  option.innerHTML = group["name"];
                  groups_el.appendChild(option);
                }
              }});
          });
        </script>
@endsection
