@extends('layout.dashboard.app')
@section('page')
add-assignment
@endsection
@section('title')
Add Assignment
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Add Assignment
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
                Assignment Title
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
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-align-left text-xl"></i>
                Description (optional)
                </span>
                <textarea
                    name="description"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Assignment Description"
                >{{ old('description') }}</textarea>
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Start Time
                </span>
                <input
                value="{{ old('start_time') }}"
                    type="datetime-local"
                    name="start_time"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                End Time
                </span>
                <input
                id="end_time"
                value="{{ old('end_time') }}"
                    type="datetime-local"
                    name="end_time"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Late Submission Time
                </span>
                <input
                id="late_time"
                value="{{ old('late_time') }}"
                    type="datetime-local"
                    name="late_time"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder=""
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-sort-amount-up text-xl"></i>
                Maximum Submissions
                </span>
                <input
                value="{{ old('max') }}"
                    type="number"
                    name="max"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="3"
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-highlighter text-xl"></i>
                Total Grade
                </span>
                <input
                value="{{ old('grade') }}"
                    type="number"
                    name="grade"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="10"
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-file-pdf text-xl"></i>
                PDF Instructions (optional)
                </span>
                <input
                    accept=".pdf"
                    type="file"
                    name="pdf"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                />
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-book text-xl"></i>
                Assign To Course
                </span>
                <select 
                required
                  id="course"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  name="course_id">
                  <option value="" disabled selected>Select a course to assign</option>
                  @foreach ($courses as $course)
                  <option value="{{ $course->id }}" >{{ $course->name }}</option>
                  @endforeach
                </select>
              </label>
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-bookmark text-xl"></i>
                Assign To Group
                </span>
                <select 
                required
                id="groups"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                 name="group_id">
                  <option value="" disabled selected>Select a course first</option>
                </select>
              </label>
              <button type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
              Next
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
