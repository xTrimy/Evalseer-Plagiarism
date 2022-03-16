@extends('layout.dashboard.app')
@section('page')
add-user
@endsection
@section('title')
Add User
@endsection
@section('content')

<main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Add User
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
                Name
                </span>
                <input
                value="{{ old('name') }}"
                type="text"
                name="name"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Name"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-envelope text-xl"></i>
                Email
                </span>
                <input
                value="{{ old('email') }}"
                type="text"
                name="email"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Email"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-signature text-xl"></i>
                Username
                </span>
                <input
                value="{{ old('username') }}"
                type="text"
                name="username"
                    required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Username"
                />
              </label>
              
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-marker text-xl"></i>
                Title (optional)
                </span>
                <input
                value="{{ old('title') }}"
                type="text"
                name="title"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Title"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-graduation-cap text-xl"></i>
                University ID (optional)
                </span>
                <input
                value="{{ old('university_id') }}"
                type="number"
                name="university_id"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="University ID"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-phone text-xl"></i>
                Phone (optional)
                </span>
                <input
                value="{{ old('phone') }}"
                type="text"
                name="phone"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Phone"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-image text-xl"></i>
                Image (optional)
                </span>
                <input
                value="{{ old('image') }}"
                accept=".png,.jpg,.jpeg"
                type="file"
                name="image"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="image"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-clock text-xl"></i>
                Birth Date (optional)
                </span>
                <input
                value="{{ old('birth_date') }}"
                type="date"
                name="birth_date"
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Birth Date"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-key text-xl"></i>
                Password 
                </span>
                <input
                value="{{ old('password') }}"
                type="password"
                name="password"
                required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Password"
                />
              </label>
              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                <i class="las la-key text-xl"></i>
                Confirm Password 
                </span>
                <input
                value="{{ old('password_confirmation') }}"
                type="password"
                name="password_confirmation"
                required
                  class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Confirm Password"
                />
              </label>
              <h2 class="text-lg mt-4 font-bold">
                User type
              </h2>
              @php
                $i=0;
              @endphp
              @foreach ($roles as $role)
              <label class="block text-sm py-2">
                <input
                @if (old("role.{$i}")==$role->name)
                  @php
                    $i++;
                  @endphp
                  checked
                @endif
                type="checkbox"
                name="role[]"
                value="{{ $role->name }}"
                class="text-orange-500"
                />
                <span class="text-gray-700 dark:text-gray-400">
                {{ ucwords(str_replace('_', ' ', $role->name)) }}
                </span>
              </label>
             
              @endforeach
              <button type="submit" class="table items-center mt-4 justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
              Add
              <span class="ml-2" aria-hidden="true">
                  <i class='las la-arrow-right'></i>
              </span>
            </button>
        </form>
          </div>
        </main>
@endsection
