@extends('layout.dashboard.app')
@section('page')
users
@endsection
@section('title')
  View Plagiarism Reports
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
                  Plagiarism Reports
                </h2>
            </div>
            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs text-center font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">#</th>
                      <th class="px-4 py-3">Question</th>
                      <th class="px-4 py-3">Report</th>
                      <th class="px-4 py-3">Released At</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @php
                   $i = 1;   
                  @endphp
                  @foreach ($plagiarism_reports as $plagiarism_report)
                  
                      <tr class="text-gray-700 dark:text-gray-400 text-center">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          </div>
                          <div>
                            <p class="font-semibold">{{ $i }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm font-bold" >
                        {{ $plagiarism_report->name ?? 'All Groups' }}
                      </td>
                      <td class="px-4 py-3 text-center" > 
                        <a href="{{ route('dashboard.users.instructors.report',['report'=>$plagiarism_report->report]) }}" class=" font-thin text-green-800">View Report</a>
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $plagiarism_report->created_at }}
                      </td>
                      
                    </tr>
                    @php
                   $i++;   
                  @endphp
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