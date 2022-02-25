@extends('layout.dashboard.app') @section('page') edit-assignment @endsection @section('title') Edit Assignment @endsection @section('content')
<main class="h-full pb-16 overflow-y-auto">
	<div class="container px-6 mx-auto grid">
		<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
         Edit Assignment
      </h2> @if(Session::has('success'))
		<div class="flex items-center justify-between px-4 p-2 mb-8 text-sm font-semibold text-green-600 bg-green-100 rounded-lg focus:outline-none focus:shadow-outline-orange">
			<div class="flex items-center"> <i class="fas fa-check mr-2"></i> <span>{{ Session::get('success') }}</span> </div>
		</div> @endif
		<!-- General elements -->
		<form method="POST" enctype="multipart/form-data" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"> @csrf @if($errors->any()) {!! implode('', $errors->all('
			<div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full" role="alert">
				<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
					<path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
				</svg> :message </div> ')) !!} @endif
			<input type="hidden" value="{{ $assignment->id }}" name="assignment_id">
			<label class="block text-sm"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-font text-xl"></i>
         Assignment Title
         </span>
				<input value="{{ $assignment->name }}" type="text" name="name" required class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Title" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-align-left text-xl"></i>
         Description (optional)
         </span>
				<textarea name="description" class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Assignment Description">{{ $assignment->description }}</textarea>
			</label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-clock text-xl"></i>
         Start Time
         </span>
				<input value="{{ date('Y-m-d\TH:i', strtotime($assignment->start_time)) }}" type="datetime-local" name="start_time" required class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-clock text-xl"></i>
         End Time
         </span>
				<input id="end_time" value="{{ date('Y-m-d\TH:i', strtotime($assignment->end_time)) }}" type="datetime-local" name="end_time" required class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-clock text-xl"></i>
         Late Submission Time
         </span>
				<input id="late_time" value="{{ date('Y-m-d\TH:i', strtotime($assignment->late_time)) }}" type="datetime-local" name="late_time" required class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-sort-amount-up text-xl"></i>
         Maximum Submissions
         </span>
				<input value="{{ $assignment->submissions }}" type="number" name="max" required class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="3" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-highlighter text-xl"></i>
         Total Grade
         </span>
				<input value="{{ $assignment->grade }}" type="number" name="grade" required class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="10" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
         <i class="las la-file-pdf text-xl"></i>
         PDF Instructions (optional)
         </span>
				<input accept=".pdf" type="file" name="pdf" class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" /> </label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
            <i class="las la-book text-xl"></i>
            Assign To Course
            </span>
				<select required id="course" class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="course_id">
					<option value="{{ $coursesSel->id }}" selected>{{ $coursesSel->name }}</option> @foreach ($courses as $course)
					<option value="{{ $course->id }}">{{ $course->name }}</option> @endforeach </select>
			</label>
			<label class="block text-sm mt-2"> <span class="text-gray-700 dark:text-gray-400">
            <i class="las la-bookmark text-xl"></i>
            Assign To Group
            </span>
				<select required id="groups" class="block w-full mt-1 text-sm border dark:border-gray-600 dark:bg-gray-700 focus:border-orange-400 focus:outline-none focus:shadow-outline-orange dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="group_id">
					<option value="{{ $assignmment->group_id ?? 1 }}" selected>{{ $assignmment->group_id ?? 'All Groups' }}</option>
				</select>
			</label>
			<button type="submit" class=" mb-10 table items-center mt-4 m-auto justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange"> Save Assignment <span class="ml-2" aria-hidden="true">
         <i class='las la-arrow-right'></i>
         </span> </button>
			<hr>
			<div class="flex justify-between mt-8 items-center">
				<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
               Assignment Questions
            </h2>
				<a href="{{ route('dashboard.assignments.add_assignment') }}">
					<button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete"> <a href="{{ route('dashboard.add_question',['id'=>$assignment->id]) }}" class="flex items-center justify-between w-full px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
            Add Question
            <i class="ml-2 las la-plus text-xl"></i>
            </a> </button>
				</a>
			</div>
			<div class="w-full overflow-hidden rounded-lg shadow-xs">
				<div class="w-full overflow-x-auto">
					<table class="w-full whitespace-no-wrap">
						<thead>
							<tr class="text-xs text-center font-semibold tracking-wide text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
								<th class="px-4 py-3">Name</th>
								<th class="px-4 py-3">Description</th>
								<th class="px-4 py-3">Grade</th>
								<th class="px-4 py-3">Actions</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"> @foreach ($questions as $question) @php $i = 0; @endphp
							<tr class="text-gray-700 dark:text-gray-400 text-center">
								<td class="px-4 py-3">
									<div class="flex items-center text-sm">
										<!-- Avatar with inset shadow -->
									</div>
									<div>
										<p class="font-semibold">{{ $question->name }}</p>
									</div>
				</div>
				</td>
				<td class="px-4 py-3 text-center w-1/3" title="{{ $question->description }}"> {{ Str::limit($question->description, 60, $end='...') }} </td>
				<td class="px-4 py-3"> {{ $question->grade }} </td>
				<td class="px-4 py-3">
					<div class="flex items-center space-x-4 text-sm justify-center">
						<button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
							<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
								<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
							</svg>
						</button>
						<button type="button" class="transition duration-150 ease-in-out flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete" data-bs-toggle="modal" data-bs-target="#exampleModal{{$i}}" onclick="openModal('modal{{$i}}')">
							<svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
							</svg>
						</button>
						<div class="modal fade fixed top-1/2 left-1/3 hidden w-2/5 h-full m-auto outline-none overflow-x-hidden overflow-y-auto justify-center z-50 px-3" id="modal{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog relative w-auto pointer-events-none">
								<div class="modal-content border-none shadow-2xl relative flex flex-col w-full pointer-events-auto m-auto bg-white bg-clip-padding rounded-md outline-none text-current">
									<div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
										<h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Delete Question</h5>
										<button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body relative p-4"> Are you sure you want to delete <span class="font-semibold">{{ $question->name }}</span> ? </div>
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
										<form action="/delete" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="question_id" value="{{ $question->id }}"> @csrf
											<button type="submit" class="px-6
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
                      ml-1">Delete</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<a href="#" style="display: block;">
							<button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete"> <a href="{{ route('dashboard.users.instructors.view_question_submission',['question_id'=>$question->id]) }}" class="flex items-center justify-between w-full px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-600 border border-transparent rounded-lg active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-orange">
      View Submissions
      <i class="ml-2 las la-eye text-xl"></i>
      </a> </button>
						</a>
					</div>
				</td>
				</tr> @php $i++; @endphp @endforeach </tbody>
				</table>
			</div>
			<div class="mt-4">
				<!-- Pagination -->
			</div>
	</div>
	</form>
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