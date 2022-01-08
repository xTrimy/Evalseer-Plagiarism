<div class="py-4 text-gray-500 dark:text-gray-400">
          <a
            class="ml-6 text-lg flex items-center font-bold text-gray-800 dark:text-gray-200"
            href="#"
          >
          <div class="w-8 h-8 inline-block mr-4">
            <img src="{{ asset('img/logo.png') }}" class="w-full h-full object-contain" alt="">
          </div>
            Evalseer
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
              @if($page == 'dashboard')
              <span
                class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              @endif
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="#"
              >
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                  ></path>
                </svg>
                <span class="ml-4">Dashboard</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
              @if($page == 'students')
              <span
                class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              @endif
              <a
                class="inline-flex items-center w-full text-sm font-semibold text-gray-500 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400"
                href="{{ route('dashboard.users.students.view') }}"
              >
                <i class="las la-users text-xl"></i>
                <span class="ml-4">Students</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              @if($page == 'instructors')
              <span
                class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              @endif
              <a
                class="inline-flex items-center w-full text-sm font-semibold text-gray-500 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-400"
                href="{{ route('dashboard.users.instructors.view') }}"
              >
                <i class="las la-users text-xl"></i>
                <span class="ml-4">Instructors</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              @if($page == 'belongings')
              <span
                class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              @endif
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="{{ route('dashboard.users.instructors.view_assignments') }}"
              >
                <i class="las la-align-left text-xl"></i>
                <span class="ml-4">Assignments</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              @if($page == 'courses')
              <span
                class="absolute inset-y-0 left-0 w-1 bg-orange-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>
              @endif
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="{{ route('dashboard.courses.view') }}"
              >
                <i class="las la-book text-xl"></i>
                <span class="ml-4">Courses</span>
              </a>
            </li>
          </ul>
          <div class="px-6 my-6">
            <a
            href="#"
              class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange"
            >
              Logout
              <i class="ml-2 las la-sign-out-alt text-xl"></i>
          </a>
          </div>
        </div>