@extends('layout.dashboard.app')
@section('page')
add-question
@endsection
@section('title')
Edit Question to {{ $assignment->name }}
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Edit Question to {{ $assignment->name }}
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
            <input type="hidden" name="question_id" value="{{ $questions->id }}">
            @if($errors->any())
                {!! implode('', $errors->all('<div class="text-red-500">:message</div>')) !!}
            @endif
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-font text-xl"></i>
                Question Title
                </span>
                <input
                value="{{ $questions->name }}"
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
                >{{ $questions->description }}</textarea>
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-highlighter text-xl"></i>
                Total Grade
                </span>
                <input
                value="{{ $questions->grade }}"
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
                value="{{ $grading_crit[$grading_criteria."_weight"] }}"
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
              <div class="mb-8">
                <div class="flex flex-col">
                  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-4 inline-block w-full sm:px-6 lg:px-8">
                      <div class="overflow-hidden">
                        <table class="w-full text-center">
                          <thead class="border-b bg-gray-400">
                            <tr>
                              <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                #
                              </th>
                              <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                Inputs
                              </th>
                              <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                Output
                              </th>
                              <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                                Actions
                              </th>
                            </tr>
                          </thead class="border-b">
                          <tbody>
                            @php
                              $i = 1;
                            @endphp
                            @foreach ($test_cases as $test_case)
                            <tr class="bg-white border-b">
                                <input type="hidden" name="tc_id" value="{{ $test_case->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">@php
                                    echo $i;
                                @endphp</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                  <input  type="text" id="input{{$i}}" name="input" class="outline-none outline-0 text-center focus:outline-0 rounded-sm" value="{{ $test_case->inputs }}">
                                  
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                  
                                  <input type="text" id="output{{$i}}" name="output" class="outline-none outline-0 text-center focus:outline-0 rounded-sm" value="{{ $test_case->output }}">
                                </td>
                                <td class="text-sm text-gray-900 font-light px-2 py-4 whitespace-nowrap">
                                  {{-- <a id="inputRef" href="{{ route('dashboard.users.instructors.edit_test_cases',['question_id'=>$test_case->id,'inputs'=>$inputs,'output'=>$test_case->output]) }}"> --}}
                                    <button type="button" id="save{{$i}}" class="px-12 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out"><i class="fas fa-check"></i> Save</button>
                                  {{-- </a> --}}
                                  <button type="button" class="inline-block px-4 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                              </form>
                            </tr class="bg-white border-b">
                              @php
                                $i++;
                              @endphp
                             @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label>Test Cases Number</label>
                <input type="number" id="count" class="form-control" placeholder="Number of Test Cases">
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
                <input type="number"  id="count_features" class="form-control" placeholder="Number of Features to check">
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

              <button type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
              Edit
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

        <script>
          function editTestCase(element) {
            var input = document.getElementById(element);
            input.readOnly = false;
            input.focus();
            input.select();
          }
        </script>
@endsection

