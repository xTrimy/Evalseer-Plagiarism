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
              <div class=" mt-8 ">
                <input
                id="search_input"
                class="w-full shadow pl-8 py-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-orange-300 focus:outline-none focus:shadow-outline-orange form-input"
                type="text"
                placeholder="Search here"
                aria-label="Search"
                />
              </div>
            <div class="flex justify-between mt-8 items-center">
                
                <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                  Assignments
                </h2>
                <a
                href="{{ route('dashboard.users.instructors.run_plag',['zipPath'=>'1','type'=>'1','question_id'=>11]) }}"
                    class="flex items-center justify-between px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange"
                >
                    Check Plagiarism
                    <i class="ml-2 fas fa-play text-xl"></i>
                </a>
            </div>
            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs text-center font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Student Name</th>
                      <th class="px-4 py-3">Submission</th>
                      <th class="px-4 py-3">Logic Feedback</th>
                      <th class="px-4 py-3">Execution Time</th>
                      <th class="px-4 py-3">Plagiarism</th>
                      <th class="px-4 py-3">Grade</th>
                      <th class="px-4 py-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach ($submissions as $submission)
                      <tr class="text-gray-700 dark:text-gray-400 text-center">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          </div>
                          <div>
                            <p class="font-semibold">{{ $submission->name }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm " >
                        <a target="_blank" href="{{ $submission->submitted_code }}">View Submission</a>
                      </td>
                      <td class="px-4 py-3 text-center" >
                        {{ $submission->logic_feedback ?? 'None' }}
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $submission->execution_time.' Sec' ?? 'Error Compiling' }}
                      </td>
                      <td class="px-4 py-3">
                        {{ $submission->plagiarism }}%
                        <br>
                        <a href="{{ route('dashboard.users.instructors.plagiarism_report') }}" class=" font-thin text-green-800">View Report</a>
                      </td>
                      <td class="px-4 py-3">
                        {{ $submission->total_grade  }}
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm justify-center">
                          <a href="{{ route('dashboard.users.instructors.edit_submission',['submission_id'=>$submission->id]) }}">
                          <button
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Edit"
                          >
                            <svg
                              class="w-5 h-5"
                              aria-hidden="true"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                            >
                              <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                              ></path>
                            </svg>
                          </button></a>
                          <button
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Delete"
                          >
                            <svg
                              class="w-5 h-5"
                              aria-hidden="true"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                              ></path>
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                  @endforeach
                  </tbody>
                </table>
                <div class="w-full bg-white text-black p-4 rounded-md border mt-8">
                  <h1 class="my-3 font-bold">Submitted Code</h1>
                  <style>
                    pre {
                      background-color:#eee;
                      overflow:auto;
                      margin:0 0 1em;
                      padding:.5em 1em;
                    }

                    pre code,
                    pre .line-number {
                      font:normal normal 14px/16px "Courier New",Courier,Monospace;
                      color:black;
                      display:block;
                    }

                    pre .line-number {
                      float:left;
                      margin:0 1em 0 -1em;
                      border-right:1px solid;
                      text-align:right;
                    }

                    pre .line-number span {
                      display:block;
                      padding:0 .5em 0 1em;
                    }

                    pre .cl {
                      display:block;
                      clear:both;
                    }
                  </style>
                 <pre><code>{{  file_get_contents(public_path($submission->submitted_code)) }}</code></pre>
                 <script>
                  (function() {
                      var pre = document.getElementsByTagName('pre'),pl = pre.length;
                      for (var i = 0; i < pl; i++) {
                        pre[i].innerHTML = '<span class="line-number"></span>' + pre[i].innerHTML + '<span class="cl"></span>';
                        var num = pre[i].innerHTML.split(/\n/).length;
                        for (var j = 0; j < num; j++) {
                          var line_num = pre[i].getElementsByTagName('span')[0];
                          line_num.innerHTML += '<span>' + (j + 1) + '</span>';
                        }
                      }
                  })();
              </script>
                </div>
                <div class="w-full bg-white text-black p-4 rounded-md border mt-8">
                  <h1 class="my-3 font-bold">Test Cases</h1>
                  <x-failed-test-cases-feedback :question="$question" :submission="$submission" />
                </div>
                <div class="w-full bg-white text-black p-4 rounded-md border mt-8">
                  <h1 class="my-3 font-bold">Syntax Feedback</h1>
                  {{ $submission->compile_feedback ?? "No Syntax Feedback"}}
                </div>
                <div class="w-full bg-white text-black p-4 rounded-md border mt-8">
                  <h1 class="my-3 font-bold">Style Feedback</h1>
                  <pre>{{ str_replace(public_path($submission->submitted_code), '', $submission->style_feedback)  ?? "No Style Feedback"  }}</pre>
                </div>
              </div>
              <div
                class="mt-4"
              >
                <!-- Pagination -->
              </div>
            </div>
          </div>
        </main>

@endsection