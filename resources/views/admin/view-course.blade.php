@extends('layout.dashboard.app') @section('page') view-course @endsection @section('title') View Course @endsection @section('content')
<main class="h-full pb-16 overflow-y-auto">
	<div class="container px-6 mx-auto grid">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
         View Course
      </h2> @if(Session::has('success'))
		<div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
			<div class="flex items-center"> <i class="fas fa-check mr-2"></i> <span>{{ Session::get('success') }}</span> </div>
		</div> @endif
		<!-- General elements -->
		<div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <h1 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Assigned Students</h1>
                <table class="w-full whitespace-no-wrap">
                    <thead>
                      <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                      >
  
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">University ID</th>
                        <th class="px-4 py-3">Reputation</th>
                        <th class="px-4 py-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody
                      class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                    @foreach ($students as $student)
                        <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div
                              class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                            >
                              <img
                                class="object-cover w-full h-full rounded-full"
                                src="{{ asset('uploadedimages/'.$student->image) }}"
                                alt=""
                                loading="lazy"
                              />
                              <div
                                class="absolute inset-0 rounded-full shadow-inner"
                                aria-hidden="true"
                              ></div>
                            </div>
                            <div>
                              <p class="font-semibold">{{ $student->name }}</p>
                            </div>
                          </div>
                        </td>
                        <td class="px-4 py-3 " >
                          {{ $student->username }}
                        </td>
                        
                        <td class="px-4 py-3 text-xs">
                          <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                        </td>
                        <td class="px-4 py-3 " >
                          {{ $student->university_id }}
                        </td>
                        <td class="px-4 py-3 " >
                          {{ $student->reputation ?? "N/A" }}
                        </td>
                        <td class="px-4 py-3">
                          <div class="flex items-center space-x-4 text-sm">
                            <button
                              class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Delete"
                            >
                            <a
                            href=""
                              class="flex items-center justify-between w-full px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-orange"
                            >
                              Remove From Course
                              <i class="ml-2 fas fa-trash text-xl"></i>
                          </a>
                            </button>
                            </a>
                          </div>
                        </td>
                      </tr>
                      
                    @endforeach
                    </tbody>
                </table>
                <h1 class="my-6 mt-10 text-2xl font-semibold text-gray-700 dark:text-gray-200">All Students</h1>
                <table class="w-full whitespace-no-wrap">
                    <thead>
                      <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                      >
  
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">University ID</th>
                        <th class="px-4 py-3">Reputation</th>
                        <th class="px-4 py-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody
                      class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                    @foreach ($studentsAll as $studentAll)
                        <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3">
                          <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div
                              class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                            >
                              <img
                                class="object-cover w-full h-full rounded-full"
                                src="{{ asset('uploadedimages/'.$studentAll->image) }}"
                                alt=""
                                loading="lazy"
                              />
                              <div
                                class="absolute inset-0 rounded-full shadow-inner"
                                aria-hidden="true"
                              ></div>
                            </div>
                            <div>
                              <p class="font-semibold">{{ $studentAll->name }}</p>
                            </div>
                          </div>
                        </td>
                        <td class="px-4 py-3 " >
                          {{ $studentAll->username }}
                        </td>
                        
                        <td class="px-4 py-3 text-xs">
                          <a href="mailto:{{ $studentAll->email }}">{{ $studentAll->email }}</a>
                        </td>
                        <td class="px-4 py-3 " >
                          {{ $studentAll->university_id }}
                        </td>
                        <td class="px-4 py-3 " >
                          {{ $studentAll->reputation ?? "N/A" }}
                        </td>
                        <td class="px-4 py-3">
                          <div class="flex items-center space-x-4 text-sm">
                            <button
                              class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                              aria-label="Delete"
                            >
                            <a
                            href=""
                              class="flex items-center justify-between w-full px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-orange"
                            >
                              Assign To Course
                              <i class="ml-2 fas fa-plus text-xl"></i>
                          </a>
                            </button>
                            </a>
                          </div>
                        </td>
                      </tr>
                      
                    @endforeach
                    </tbody>
                </table>
        </div>
        <div class="mt-4">
            <!-- Pagination -->
        </div>
    </div>
	</div>
</main>
<script>
let end_time_el = document.getElementById('end_time');
let late_time_el = document.getElementById('late_time');
end_time_el.addEventListener('change', function() {
	late_time_el.value = this.value;
});
let course_el = document.getElementById('course');
let groups_el = document.getElementById('groups');
const val = this.value;
const api = "/api/course/" + val + "/groups";
$.ajax({
	url: api,
	success: function(result) {
		const groups = result["groups"];
		// groups_el.innerHTML = "<option value='' selected disabled>Select a group to assign</option>";
		// groups_el.innerHTML += "<option value='' >All Groups</option>";
		for(let i = 0; i < groups.length; i++) {
			const group = groups[i];
			let option = document.createElement('option');
			option.value = group["id"];
			option.innerHTML = group["name"];
			groups_el.appendChild(option);
		}
	}
});
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
</script> @endsection