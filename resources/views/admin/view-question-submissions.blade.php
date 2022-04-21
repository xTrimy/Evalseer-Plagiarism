@php
session_start();   
@endphp
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
              <div class=" mt-8 mb-8">
                <input
                id="search_input"
                class="w-full shadow pl-8 py-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-orange-300 focus:outline-none focus:shadow-outline-orange form-input"
                type="text"
                placeholder="Search here"
                aria-label="Search"
                />
              </div>
              @if(Session::has('success'))
              <div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
                <div class="flex items-center"> <i class="fas fa-check mr-2"></i> <span>{{ Session::get('success') }}</span> </div>
              </div> @endif
            <div class="flex justify-between mt-8 items-center">
                
                <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                  Assignments
                </h2>
                 <div class="flex">
                   <a
                href="{{ route('dashboard.plagiarism_checker.question',$question_id) }}"
                    class="mr-4 flex items-center justify-between px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                >
                    Check Plagiarism Using SCOSS
                    <i class="ml-2 fas fa-play text-xl"></i>
                </a>
                 <a
                href="{{ route('dashboard.users.instructors.run_plag',['zipPath'=>'1','type'=>'cpp','question_id'=>$question_id]) }}" 
                    class="flex items-center justify-between px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange"
                >
                    Check Plagiarism
                    <i class="ml-2 fas fa-play text-xl"></i>
                </a>
                 </div>
               
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
                  @php $i = 0; @endphp 
                  @foreach ($submissions as $submission)
                      <tr class="text-gray-700 dark:text-gray-400 text-center">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          </div>
                          <div>
                            <p class="font-semibold">{{ $submission->user->name }}</p>
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
                      <td class="px-4 py-3" id="plagValue">
                        @if ($submission->plagiarism != null)
                          <a href="{{ route('dashboard.users.instructors.report',['report'=>$submission->plagiarism]) }}" class=" font-thin text-green-800">View Report</a>
                        @elseif($submission->plagiarism_report->first())
                        @php
                          $report = unserialize($submission->plagiarism_report->first()->score);
                          $count_operator = $report->count_operator * 100;
                          $set_operator = $report->set_operator * 100;
                          $hash_operator = $report->hash_operator * 100;
                          $token_based = $report->token_based * 100;
                        @endphp
                        <a href="{{ route('dashboard.plagiarism_checker.compare',$submission->plagiarism_report->first()->id) }}">{{ $count_operator."%" }}</a>
                        @else
                          N/A
                        @endif
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
                          </button>
                        </a>
                          <button
                          onclick="openModal('modal{{$i}}')"
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
                            <div class="modal fade fixed top-1/2 left-1/3 hidden w-2/5 h-full m-auto outline-none overflow-x-hidden overflow-y-auto justify-center z-50 px-3" id="modal{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog relative w-auto pointer-events-none">
                              <div class="modal-content border-none shadow-2xl relative flex flex-col w-full pointer-events-auto m-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                  <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Delete Submission</h5>
                                  <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body relative p-4"> Are you sure you want to delete this submission ? </div>
                                <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                                  <button type="button" class="px-6 
                                  py-2.5
                                  bg-gray-600
                                  text-white
                                  font-medium
                                  text-xs
                                  leading-tight
                                  uppercase
                                  rounded
                                  shadow-md
                                  hover:bg-gray-700 hover:shadow-lg
                                  focus:bg-gray-700 focus:shadow-lg focus:outline-none focus:ring-0
                                  active:bg-gray-800 active:shadow-lg
                                  transition
                                  duration-150
                                  ease-in-out" data-bs-dismiss="modal" onclick="closeModal('modal{{$i}}')">Close</button>
                                  {{-- <form action="/delete" method="POST" enctype="multipart/form-data"> --}}
                                    <input type="hidden" name="question_id" value="{{ $submission->id }}"> @csrf
                                    <a href="{{route('dashboard.users.instructors.delete_submission',['submission_id'=>$submission->id])}}"><button type="button"  class="px-6
                                    py-2.5
                                    bg-red-600
                                    text-white
                                    font-medium
                                    text-xs
                                    leading-tight
                                    uppercase
                                    rounded
                                    shadow-md
                                    hover:bg-red-700 hover:shadow-lg
                                    focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0
                                    active:bg-red-800 active:shadow-lg
                                    transition
                                    duration-150
                                    ease-in-out
                                    ml-1">Delete</button></a>
                                  {{-- </form> --}}
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <a href="{{ route('dashboard.users.instructors.view_submission',['submission_id'=>$submission->id]) }}" style="display: block;">
                            <button
                              class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Delete"
                            >
                              <i class="fas fa-eye text-xl"></i>
                            </button>
                            {{-- @php
                              $plag_content = file_get_contents($_SESSION['plag'].'match3-link.html');
                            @endphp --}}

                            <div type="hidden" id="plagg" class=" hidden">@php echo $_SESSION['plag'] ?? '' @endphp</div>
                          </a>
                        </div>
                      </td>
                    </tr>
                    @php $i++; @endphp
                  @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="mt-4"
              >
                <!-- Pagination -->
              </div>
            </div>
          </div>
        </main>
        <script>
          function openModal(modalId) {
            modal = document.getElementById(modalId)
            modal.classList.remove('hidden')
          }

          function closeModal(modalId) {
            modal = document.getElementById(modalId)
            modal.classList.add('hidden')
          }

          // var content = document.getElementById('plagg').innerHTML;

          // var str = content; // your HTML string

          // var doc = new DOMParser().parseFromString(str, "text/html") 
          
          // console.log( doc.getElementById("rounded_percent").innerHTML )

          // var plagValue = document.getElementById('plagValue').innerHTML = doc.getElementById("rounded_percent").innerHTML;

          
        </script>

@endsection