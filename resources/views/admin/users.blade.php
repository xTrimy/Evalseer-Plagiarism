@extends('layout.dashboard.app')
@section('page')
users
@endsection
@section('title')
  {{ $data_name??"Users"  }}s
@endsection
@section('content')
        <main class="h-full pb-16 overflow-y-auto">
          
          <div class="container grid px-6 mx-auto">
            <div class=" mt-8 ">
              <input
              id="search"
              name="search"
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
                  {{ $data_name??"Users" }}s
                </h2>
                
                <a href="{{ route('dashboard.users.add') }}">
                    <button class="py-2 px-8 text-white rounded-lg bg-orange-600 hover:bg-orange-500 active:bg-orange-400 text-lg ring-0 transition-all active:ring-4 ring-orange-200 dark:ring-orange-800">
                        <i class="las la-plus text-2xl"></i> Add {{ $data_name??"User" }}
                    </button>
                </a>
            </div>
            @if(Session::has('success'))
		<div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
			<div class="flex items-center"> <i class="fas fa-check mr-2"></i> <span>{{ Session::get('success') }}</span> </div>
		</div> @endif
            
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th>@sortablelink('name', 'Name')</th>
                      <th class="px-4 py-3">Role</th>
                      <th>@sortablelink('username', 'Username')</th>
                      <th>@sortablelink('email', 'Email')</th>
                      <th class="px-4 py-3">University ID</th>
                      <th class="px-4 py-3">Reputation</th>
                      <th class="px-4 py-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  @php
                   $i = 0;   
                  @endphp
                  @foreach ($users as $user)
                  
                      <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->
                          <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="{{ asset('uploadedimages/'.$user->image) }}"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          <div>
                            <p class="font-semibold">{{ $user->name }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm font-bold" >
                        {{ ucfirst($user->getRoleNames()[0]??"N/A"); }}
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $user->username }}
                      </td>
                      
                      <td class="px-4 py-3 text-xs">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $user->university_id }}
                      </td>
                      <td class="px-4 py-3 " >
                        {{ $user->reputation ?? "N/A" }}
                      </td>
                      <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <a href="{{ route('dashboard.users.instructors.edit-user',['user_id'=>$user->id]) }}">
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
                            onclick="openModal('modal{{$i}}')"
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
                                  <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Delete User</h5>
                                  <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body relative p-4"> Are you sure you want to delete this user ? </div>
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
                                    <input type="hidden" name="question_id" value="{{ $user->id }}"> @csrf
                                    <a href="{{route('dashboard.users.instructors.delete-user',['user_id'=>$user->id])}}">
                                      <button type="button"  class="px-6
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
                                </div>
                              </div>
                            </div>
                          </div>
                          @php
                   $i++;   
                  @endphp
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
                  {{ $users->links() }}
              </div>
            </div>
          </div>
        </main>
        <script type="text/javascript">
        $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
        type : 'get',
        url : '{{URL::to('dashboard/users/students/search')}}',
        data:{'search':$value},
        success:function(data){
        $('tbody').html(data);
        $('tbody').addClass("bg-white");
        $('tbody').addClass("divide-y");
        $('tbody').addClass("dark:divide-gray-700");
        $('tbody').addClass("dark:bg-gray-800");
        console.log(data);
        }
        });
        })
        </script>
        <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>
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