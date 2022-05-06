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
                <i class="las la-language text-xl"></i>
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
              <label class="block text-sm mt-2">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-file text-xl"></i>
                Main File (Optional)
                </span>
                <input
                    accept=""
                    type="file"
                    name="main_file"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                />
              </label>
              
              <div class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  <i class="las la-code text-xl"></i>
                  Base Skeleton
                </span>
                <input type="hidden" id="base_skeleton_input" name="base_skeleton">
                <div class="w-full flex bg-slate-600">
                <div class="flex overflow-x-auto">
                    <div data-file-order="1" class="flex items-center relative file_tab py-2 px-4 cursor-pointer bg-slate-800 hover:bg-slate-800 border-b-2 text-white border-b-orange-500">
                        <div class="icon w-6 h-6 mr-2"></div>
                        <div class="file_name">Main.php</div>
                        <input type="text" class="border-0 hidden absolute bg-transparent w-1/2 ml-8 p-0">
                    </div>
                </div>
                <div id="add_file_button" class="current_file_tab flex file_tab py-4 px-4 bg-slate-700 hover:bg-green-800 cursor-pointer  text-white">
                    <i class="las la-plus"></i>
                </div>
              </div>
              <div class="w-full h-56">
                <div onkeydown="editor_keyboard_shortcuts(event,this,0)" onkeyup="editor_keyboard_shortcuts(event,this,1)" id="editor" class="w-full h-full">
                    <div id="editor-1" class="current_editor ace_file_editor w-full h-full"></div>
                    <input type="hidden" name="base_skeleton_file[]" id="editor-1">
                </div>              
              </div>
              </div>
              <p class="text-gray-600 mt-4 dark:text-gray-400">Check for plagiarism in external sites?</p>
              <button type="button" onclick="search_external_sources(this)"
              class="group table items-center mb-4 justify-between relative overflow-hidden disabled:cursor-not-allowed px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
              >
              <div class="loading group-disabled:block hidden absolute top-0 left-0 w-full h-full bg-gray-700 ">
                  <div class="lds-ring small"><div></div><div></div><div></div><div></div></div>
              </div>
              Search For External Source Codes</button>
              <div  id="external_source_codes_container">

              </div>
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
   <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
   <script src="{{ asset('ace/build/src/ace.js') }}" type="text/javascript" charset="utf-8"></script>
   <script src="{{ asset('ace/build/src/ext-language_tools.js') }}" type="text/javascript" charset="utf-8"></script>
   <script src="{{ asset('ace/build/src/ext-error_marker.js') }}" type="text/javascript" charset="utf-8"></script>      <script>
         var ace_editor;
       window.onload=function(){
             ace_editor = ace.edit("editor-1");
            ace_editor.setTheme("ace/theme/monokai");
            ace_editor.setOptions({
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: true
            });
            // ace_editor.getSession().setAnnotations([{
            //     row: 1,
            //     column: 0,
            //     text: "Error Message", 
            //     type: "warning" //This would give a red x on the gutter
            // }]);
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

      <script>
        function search_external_sources(element){
          element.disabled = true;
          $.ajax({
            url: "{{ route('dashboard.code_searcher.search') }}?keyword=Binary%20Search%20C++",
            context: document.body
          }).done(function(data) {
            element.removeAttribute('disabled');
            if(data["error"]){
              console.log("Error while fetching data: "+data["error"]);
              return;
            }
            let response = data["codes"];
            for(let i = 0; i<response.length; i++){
              var pre = document.createElement('pre');
              pre.classList.add('bg-gray-700');
              pre.classList.add('text-white');
              pre.classList.add('mb-4');
              pre.innerHTML = response[i][1].replace('\n','<br>');
              document.getElementById('external_source_codes_container').appendChild(pre);
            }
          });
        }
      </script>
@endsection
