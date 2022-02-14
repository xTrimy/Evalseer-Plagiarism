@extends('layout.dashboard.app')
@section('page')
courses
@endsection
@section('title')
Courses
@endsection
@section('content')
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <div class="flex justify-between mt-8 items-center">
                <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                >
                Courses
                </h2>
                <a href="{{ route('dashboard.courses.add') }}">
                    <button class="py-2 px-8 text-white rounded-lg bg-orange-600 hover:bg-orange-500 active:bg-orange-400 text-lg ring-0 transition-all active:ring-4 ring-orange-200 dark:ring-orange-800">
                        <i class="las la-plus text-2xl"></i> Add Course
                    </button>
                </a>
            </div>
           
            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Name</th>
                      <th class="px-4 py-3">Code</th>
                      <th class="px-4 py-3">Credit Hours</th>
                      <th class="px-4 py-3">Grade</th>
                      <th class="px-4 py-3">Status</th>
                      <th class="px-4 py-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @foreach ($courses as $course)
                      <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{ asset('png/course.png') }}"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          <div>
                            <p class="font-semibold">{{ $course->name }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm font-bold" >
                        {{ $course->course_id }}
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $course->credit_hours }}
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $course->grade }}
                      </td>
                      <td class="px-4 py-3 text-xs">
                        @if($course->active == 1)
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                          Active
                        </span>
                        @else
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100"
                        >
                          Not Active
                        </span>
                        @endif
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
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
                          <a href="#" style="display: block;">
                            <button
                              class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Delete"
                            >
                              <i class="fas fa-eye text-xl"></i>
                            </button>
                          </a>
                        </div>
                      </td>
                    </tr>
                    
                  @endforeach
                  </tbody>
                </table>
              </div>
              <div
                class="mt-4"
              >
                <!-- Pagination -->
                  {{ $courses->links() }}
              </div>
            </div>
          </div>
        </main>

@endsection