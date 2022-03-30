@extends('layout.dashboard.app')
@section('page')
add-question
@endsection
@section('title')
Add Question to {{ $assignment->name }}
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Add Question to {{ $assignment->name }}
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
             @if(Session::has('error'))
            <div
              class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-red-600 bg-red-100 rounded-lg focus:outline-none focus:shadow-outline-orange"
            >
              <div class="flex items-center">
                <i class="fas fa-times mr-2"></i>
                <span>{{ Session::get('error') }}</span>
              </div>
            </div>
            @endif
            <!-- General elements -->
            <form method="POST" enctype="multipart/form-data"
              class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >
            @csrf
            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
            @if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Question Title
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
                Description 
                </span>
                <textarea
                    name="description"
                    id="summernote"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Assignment Description"
                >{{ old('description') }}</textarea>
              </label>
              <label class="block text-sm">
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
                  placeholder="5"
                />
              </label>
              <h1 class="text-xl text-black font-bold mt-4">
                Grading Criteria %
              </h1>
              @foreach ($grading_criterias as $grading_criteria)
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                {{ ucwords(str_replace('_', ' ', $grading_criteria)); }}
                </span>
                <input
                value="{{ old($grading_criteria) }}"
                type="number"
                name="{{ $grading_criteria }}"
                  required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  value="0"
                  placeholder="30"
                />
              </label>                
              @endforeach
              <h2 class="font-bold text-xl mt-8">Test Cases</h2>
              <div class="form-group">
                <label>Test Cases Number</label>
                <input type="number"  id="count" class="form-control" placeholder="Number of Test Cases">
                <input type="button" name="addd" class="px-4 py-2 rounded bg-green-500 text-white" onclick="addField()" placeholder="" value="Add">
              </div>
              <div id="test_cases" class="hidden">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                  Input
                  </span>
                  <input
                  type="text"
                  name="input[]"
                    class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="5"
                  />
                </label>
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                  Output
                  </span>
                  <input
                  type="text"
                  name="output[]"
                    class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="5"
                  />
                </label>
              </div>
              <div class="my-4" id="container">
                
              </div>
              <h1 class="text-xl text-black font-bold mt-4">
                Feature Checking
              </h1>
              <div class="form-group">
                <label>Features Count</label>
                <input type="number" name="features_count" id="count_features" class="form-control" placeholder="Number of Features to check">
                <input type="button" name="addd" class="px-4 py-2 rounded bg-green-500 text-white" onclick="addFeatureField()" placeholder="" value="Add">
              </div>
              
              <div id="feature_checking" class="hidden">
                <div class="flex">
                  <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  Feature Text (Seperate with ,)
                  </span>
                  <input
                  type="text"
                  name="feature[]"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="if,else"
                  />
                </label>
                <label class="block text-sm ml-2">
                  <span class="text-gray-700 dark:text-gray-400">
                  Occurrences
                  </span>
                  <input
                  type="text"
                  name="occurrences[]"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="2"
                  />
                </label>
                </div>
                
                
              </div>
              <div class="my-4" id="container2">
                
              </div>

              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Programming Language
                </span>
                <select name="programming_language"
                required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                >
                  <optgroup label="Course">
                    @foreach ($assignment->course->programming_languages as $lang)
                      <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                    @endforeach
                  </optgroup>
                  <optgroup label="All">
                    @foreach ($programming_languages as $lang)
                      <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                    @endforeach
                  </optgroup>
                </select>
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  <i class="las la-font text-xl"></i>
                  Base Skeleton
                </span>
                <input type="hidden" id="base_skeleton_input" name="base_skeleton">
                <div  id="ace_editor" class="w-full h-64"></div>
              </label>
              <button id="submit_button" type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
              Add
              <span class="ml-2" aria-hidden="true">
                  <i class='las la-arrow-right'></i>
              </span>
            </button>
        </form>

          </div>
        </main>
        <script type='text/javascript'>
            

            function addField()
            {
                var number = document.getElementById("count").value;
                var container = document.getElementById("container");
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }
                for (i=0;i<number;i++){
                    var test_cases = document.getElementById('test_cases').cloneNode(true);
                    container.appendChild(test_cases);
                    test_cases.classList.remove('hidden');
                    container.appendChild(document.createElement("br"));
                }
            }
        </script>
        <script type='text/javascript'>
            function addFeatureField()
            {
                var number = document.getElementById("count_features").value;
                var container = document.getElementById("container2");
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }
                for (i=0;i<number;i++){
                    var feature_checking = document.getElementById('feature_checking').cloneNode(true);
                    container.appendChild(feature_checking);
                    feature_checking.classList.remove('hidden');
                    container.appendChild(document.createElement("br"));
                }
            }
        </script>
        <script>
          $(document).ready(function() {
            $('#summernote').summernote();
          });
        </script>
   <script src="{{ asset('ace/build/src/ace.js') }}" type="text/javascript" charset="utf-8"></script>
      <script>
        var ace_editor;
       window.onload=function(){
             ace_editor = ace.edit("ace_editor");
            ace_editor.setTheme("ace/theme/monokai");
            ace_editor.session.setMode("ace/mode/c_cpp");
            ace_editor.session.setValue(`{{ old('base_skeleton') }}`);
       }
       var submit_button = document.getElementById('submit_button');
       let base_skeleton_input = document.getElementById('base_skeleton_input');
       let form = document.querySelector('form');
       submit_button.addEventListener('click',function(e){
              e.preventDefault();
              let base_skeleton = ace_editor.getSession().getValue();
              base_skeleton_input.value = base_skeleton;
              form.submit();
        });
      </script>
@endsection
