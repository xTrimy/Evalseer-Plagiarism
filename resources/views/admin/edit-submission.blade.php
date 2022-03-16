@extends('layout.dashboard.app')
@section('page')
edit-submission
@endsection
@section('title')
Edit Submission
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Edit Submission
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
            <input type="hidden" name="submission_id" value="{{ $submissions->id }}" >
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Student Name
                </span>
                <input
                value="{{ $submissions->name }}"
                type="text"
                name="name"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Title"
                  disabled
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Submission
                </span>
                {{-- <input
                value="{{ $submissions->user_id }}"
                type="text"
                name="course_code"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Course Code"
                /> --}}
                <br>
                
              </label>
              <div class="text-left flex">
                <div>
                    <a href="{{ $submissions->submitted_code }}" target="_blank" class="mr-3">
                        <button type="button" class="py-2 px-8 text-blue-500  rounded-lg bg-white border border-blue-500 active:bg-blue-400 text-lg transition-all ring-orange-200 dark:ring-orange-800">
                            View Submission
                        </button>
                    </a>
                </div>
                <div class="">
                <a href="{{ $submissions->submitted_code }}" download>
                    <button type="button" class="py-2 px-8 text-white rounded-lg bg-blue-600 hover:bg-blue-500 active:bg-blue-400 text-lg transition-all ring-orange-200 dark:ring-orange-800">
                        <i class="fas fa-download"></i>  Download Submisison
                    </button>
                </a>
                </div>
               </div>
              <hr class="my-4">
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Logic Feedback
                </span>
                <input
                value="{{ $submissions->logic_feedback }}"
                type="text"
                name="logic_feedback"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Credit Hours"
                />
              </label>
              
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-marker text-xl"></i>
                Execution Time
                </span>
                <div class="flex justify-center items-center">
                    <input
                    value="{{ $submissions->execution_time }}"
                    type="text"
                    name="execution_time"
                    id="execution_time"
                        required
                    class="mr-2 block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Grade"
                    readonly
                    />
                    <div class="">
                        <button onclick="override('execution_time')" type="button" class="py-2 px-8 text-white rounded-md bg-red-600 hover:bg-red-500 active:bg-red-400 text-sm transition-all ring-orange-200 dark:ring-orange-800">
                                Override
                        </button>
                    </div>
                </div>
                
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-graduation text-xl"></i>
                Plagiarism
                </span>
                <div class="flex justify-center items-center">
                    <input
                    value="{{ $submissions->plagiarism ?? "0"}}"
                    type="text"
                    name="plagiarism"
                    id="plagiarism"
                        required
                    class="mr-2 block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Minimum Grade To Pass"
                    readonly
                    />
                    <div class="">
                        <button onclick="override('plagiarism')" type="button" class="py-2 px-8 text-white rounded-md bg-red-600 hover:bg-red-500 active:bg-red-400 text-sm transition-all ring-orange-200 dark:ring-orange-800">
                                Override
                        </button>
                    </div>
                </div>
                
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Grade
                </span>
                <div class="flex justify-center items-center">
                    <input
                    value="{{ $submissions->total_grade }}"
                    type="text"
                    name="total_grade"
                    id="total_grade"
                        required
                    class="mr-2 block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Course Start Date"
                    readonly
                    />
                    <div class="">
                        <button onclick="override('total_grade')" type="button" class="py-2 px-8 text-white rounded-md bg-red-600 hover:bg-red-500 active:bg-red-400 text-sm transition-all ring-orange-200 dark:ring-orange-800">
                                Override
                        </button>
                    </div>
                </div>
              </label>
              <div class="flex mt-3">
                <div class="form-check form-switch">
                  <input class="form-check-input appearance-none w-9 rounded-full float-left outline-none h-6 align-top bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm outline-0 mr-2" type="checkbox" name="active" role="switch" id="flexSwitchCheckDefault" 
                  <label class="form-check-label inline-block text-gray-800 outline-none" for="flexSwitchCheckDefault">Block Grade</label>
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

          function override(element) {
            var input = document.getElementById(element);
            input.readOnly = false;
            input.focus();
            input.select();
          }
        </script>
@endsection
