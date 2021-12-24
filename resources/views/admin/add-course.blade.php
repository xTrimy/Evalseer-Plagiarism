@extends('layout.dashboard.app')
@section('page')
add-course
@endsection
@section('title')
Add Course
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Add Course
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
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Course Title
                </span>
                <input
                value="{{ old('name') }}"
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
                value="{{ old('course_code') }}"
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
                value="{{ old('credit_hours') }}"
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
                value="{{ old('grade') }}"
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
                value="{{ old('grade_to_pass') }}"
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
                value="{{ old('start_date') }}"
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
                value="{{ old('end_date') }}"
                type="date"
                name="end_date"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Course End Date"
                />
              </label>
              <button type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
              Add
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
