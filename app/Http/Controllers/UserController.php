<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Course;
use App\Models\Assignments;
use App\Models\Submission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Filesystem\Filesystem;
use App\Models\Questions;
use File;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:6|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request['password']);
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        event(new Registered($user));

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $credentials  = $request->only(['email','password']);
        //|| Auth::attempt(['username' => request('email'), 'password' => request('password')])
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')]) ) {
            $user = Auth::user();
            $this->earn_rank($user->id,1);
            if ($user->number_of_logins == null) {
                $user->number_of_logins = 1;
                $user->save();
            } else {
                $user->number_of_logins += 1;
                $user->reputation += 5;
                $user->save();
                $this->check_for_badge($user->id);
            }

            $request->session()->regenerate();
            return redirect()->route('home');
        }
        return back()->withInput()->with('status','Invalid login details!');
    }

    //User Views START
    public function dashboard_users($users=null,$title="User"){
        $users = $users ?? User::paginate(15);
        return view('admin.users',['data_name'=>$title,'users'=>$users]);
    }

    public function dashboard_view_students(){
        // $users = User::role('student')->paginate(15);
        $users = User::role('student')->sortable()->paginate(15);
        return $this->dashboard_users($users,"Student");
    }

    public function dashboard_view_instructors(){
        $users = User::role('instructor')->paginate(15);
        return $this->dashboard_users($users, "Instructor");
    }

    public function dashboard_view_assignments(){
        $users = User::role('instructor')->paginate(15);
        // $assignments = Assignments::all()->join('courses', 'courses.course_id', '=', 'course_id');
        $assignments = DB::table('assignments')
                        ->leftJoin('courses', 'assignments.course_id', '=', 'courses.id')
                        ->select('assignments.*', 'courses.course_id')
                        ->get();
        return view('instructor.view-assignments',['users'=>$users,'assignments'=>$assignments]);
    }

    public function view_assignment_questions($assignment_id) {
        // dd($assignment_id);
        $users = User::role('instructor')->paginate(15);

        $questions = DB::table('questions')
                        ->where('assignment_id',$assignment_id)
                        ->select('questions.*')
                        ->get();
        return view('instructor.view-assignments-questions',['users'=>$users,'questions'=>$questions]);
    }

    public function view_question_submission($question_id) {
        // dd($assignment_id);
        $users = User::role('instructor')->paginate(15);

        $submissions = DB::table('submissions')
                        ->where('submissions.question_id', $question_id)
                        ->leftJoin('users', 'submissions.user_id', '=', 'users.id')
                        ->select('submissions.*', 'users.name')
                        // ->distinct('user_id')
                        ->get();

        $submissions_grades = DB::table('submissions')
                        ->where('submissions.question_id', $question_id)
                        ->select('submissions.total_grade', 'submissions.id')
                        ->get();


        $data = [];
 
        foreach($submissions_grades as $row) {
            // dd($row);
            $data['label'][] = $row->id;
            $data['data'][] = (int) $row->total_grade;
        }
    
        $data['chart_data'] = json_encode($data);

    
        $submissions = Submission::where('question_id',$question_id)->with(['user','plagiarism_report'])->get();
                        // dd($submissions);
        return view('instructor.view-question-submissions',['users'=>$users,'submissions'=>$submissions,'question_id'=>$question_id,'data'=>$data]);
    }

    public function all_courses() {
        $user = Auth::user();

        $user_courses = $user->courses;

        return view('all-courses',['courses'=>Course::all(),'user_courses'=>$user_courses]);
    }

    public function view_submission($submission_id) {
        // dd($assignment_id);
        $users = User::role('instructor')->paginate(15);

        $submissions = DB::table('submissions')
                        ->where('submissions.id', $submission_id)
                        ->leftJoin('users', 'submissions.user_id', '=', 'users.id')
                        ->select('submissions.*', 'users.name')
                        ->distinct('user_id')
                        ->take(1)
                        ->get();

        return view('instructor.view-submission',['users'=>$users,'submissions'=>$submissions]);
    }
    //User Views END

    //User Add START
    public function add()
    {
        $roles = Role::all();
        return view('admin.add-user',['roles'=>$roles]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'username'=>"required|string",
            'email'=>"required|email|unique:users,email",
            'birth_date'=>"nullable|date",
            'title'=>'nullable|string',
            'university_id'=>'nullable|string',
            'image' => "nullable|mimes:jpg,jpeg,png|max:1024",
            'phone' => "nullable|string",
            'password'=>"required|confirmed|string|min:6",
            'role'=>"required|array|min:1",
            'role.*'=>"required|string|exists:roles,name",
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->title = $request->title;
        $user->university_id = $request->university_id;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $request->name . '-' . time() . '.' . $extension;
            $path = public_path('uploadedimages/');
            $request->file('image')->move($path , $fileNameToStore);
            $user->image = $fileNameToStore;
        } else {
            $user->image = "user.png";
        }
        $user->save();
        foreach ($request->role as $role) {
            $user->assignRole($role);
        }
        return redirect()->back()->with('success','User Created Successfully!');
    }
    //User Add END

    public function edit_user($user_id) {
        $user = User::find($user_id);

        return view('instructor.edit-user',['user'=>$user]);
    }

    public function edit(Request $request) {
        $request->validate([
            'name'=>'required|string',
            'username'=>"required|string",
            'email'=>"required",
            'birth_date'=>"nullable|date",
            'title'=>'nullable|string',
            'university_id'=>'nullable|string',
            'image' => "nullable|mimes:jpg,jpeg,png|max:1024",
            'phone' => "nullable|string",
        ]);
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->title = $request->title;
        $user->university_id = $request->university_id;
        $user->phone = $request->phone;
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $request->name . '-' . time() . '.' . $extension;
            $path = public_path('uploadedimages/');
            $request->file('image')->move($path , $fileNameToStore);
            $user->image = $fileNameToStore;
        } else {
            $user->image = "user.png";
        }
        $user->save();
        return redirect()->back()->with('success','User Edited Successfully!');

    }

    public function delete_user($user_id) {
        $user = User::find($user_id);
        $user->delete();

        return redirect()->back()->with('success',"User Deleted Successfully");
    }

    public function edit_submission($submission_id) {
        $users = User::role('instructor')->paginate(15);

        $submissions = DB::table('submissions')
                        ->where('submissions.id', $submission_id)
                        ->leftJoin('users', 'submissions.user_id', '=', 'users.id')
                        ->select('users.name','submissions.*')
                        ->get()
                        ->first();
        // dd($submissions);
        return view('instructor.edit-submission',['users'=>$users,'submissions'=>$submissions]);
    }

    public function edit_sub(Request $request) {

        $submission = Submission::find($request->submission_id);

        // dd($request);

        $submission->logic_feedback = $request->logic_feedback;
        $submission->execution_time = $request->execution_time;
        $submission->plagiarism = $request->plagiarism;
        $submission->total_grade = $request->total_grade;
        if($request->is_blocked == "on") {
            $submission->is_blocked = true;
        } else {
            $submission->is_blocked = false;
        }

        $submission->save();
        return redirect()->back()->with('success','Submission Edited Successfully!');

    }

    public function logout() {
        Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function home_instructor() {
        $users = User::role('student')->get();
        $users = count($users);

        $assignmentss = Assignments::get();
        $assignments = count($assignmentss);

        $submissionss = Submission::get();
        $submissions = count($submissionss);

        $swe211_assignment = Assignments::where('course_id', '1')->get();
        $swe212_assignment = Assignments::where('course_id', '2')->get();
        $se305_assignment = Assignments::where('course_id', '3')->get();

        $swe211 = 0;
        $swe212 = 0;
        $se305 = 0;

        foreach ($submissionss as $submission) {
            $question = Questions::find($submission->question_id);
            foreach ($swe211_assignment as $assignment) {
                if($question->assignment_id == $assignment->id) {
                    $swe211++;
                }
            }

            foreach ($swe212_assignment as $assignment) {
                if($question->assignment_id == $assignment->id) {
                    $swe212++;
                }
            }

            foreach ($se305_assignment as $assignment) {
                if($question->assignment_id == $assignment->id) {
                    $se305++;
                }
            }
        }

        return view('instructor.index',["users"=>$users,"assignments"=>$assignments,"submissions"=>$submissions,"swe211"=>$swe211,"swe212"=>$swe212,"se305"=>$se305]);
    }

    public function search (Request $request) {
        if($request->ajax()) {
            $output="";
            $users=User::where('name','LIKE','%'.$request->search."%")->get();
            if($users) {
                $i=0;
                foreach ($users as $key => $user) {
                    $image = asset('uploadedimages/'.$user->image);
                    $role = ucfirst($user->getRoleNames()[0]??"N/A");
                    $output.='<tr>'.
                    '<td class="px-4 py-3">'.
                    '<div class="flex items-center text-sm">
                    <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                          >
                            <img
                              class="object-cover w-full h-full rounded-full"
                              src="'.$image.'"
                              alt=""
                              loading="lazy"
                            />
                            <div
                              class="absolute inset-0 rounded-full shadow-inner"
                              aria-hidden="true"
                            ></div>
                          </div>
                          
                          <div>
                            <p class="font-semibold">'.$user->name.'</p>
                          </div>
                    </div>'.
                    '</td>'.
                    '<td class="px-4 py-3 text-sm font-bold">'.$role.'</td>'.
                    '<td class="px-4 py-3 ">'.$user->username.'</td>'.
                    '<td class="px-4 py-3 text-xs"><a href="mailto:'.$user->email.'">'.$user->email.'</a></td>'.
                    '<td class="px-4 py-3 ">'.$user->university_id.'</td>'.
                    "<td class='px-4 py-3' >
                        ". ($user->reputation ?? 'N/A')."
                      </td>".
                    '
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                          <a href="'.route("dashboard.users.instructors.edit-user",["user_id"=>$user->id]).'">
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
                            onclick="openModal(\'modal'.$i.'\')">
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
                          <div class="modal fade fixed top-1/2 left-1/3 hidden w-2/5 h-full m-auto outline-none overflow-x-hidden overflow-y-auto justify-center z-50 px-3" id="modal'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                  ease-in-out" data-bs-dismiss="modal" onclick="closeModal(\'modal'.$i.'\')">Close</button>
                                    <input type="hidden" name="question_id" value="'.$user->id.'"> 
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <a href="'.route("dashboard.users.instructors.delete-user",["user_id"=>$user->id]).'">
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
                    '.
                    '</tr>';
                    $i++;
                    // $output = $user->name;
                }
                return Response($output);
            }
        }
    }

    public function check_for_badge($user_id) {
        $user = User::find($user_id);
        $ranks = DB::table('ranks')->distinct()->get();
        foreach ($ranks as $rank) {
            if ($user->reputation == $rank->score) {
                $this->earn_rank($user_id,$rank->id);
            } else if ($user->number_of_logins == $rank->number_of_logins) {
                $this->earn_rank($user_id,$rank->id);
            }
        }
    }

    public function earn_badge($user_id,$badge_id) {
        $hasBadge = false;

        $user_badges = DB::table('user_badges')
                        ->where('user_id',$user_id)
                        ->select('user_badges.badge_id')
                        ->get();

        foreach ($user_badges as $user_badge) {
            if($user_badge->badge_id == $badge_id) {
                $hasBadge = true;
            }
        }

        if(!$hasBadge) {
            $date = date('Y/m/d h:i:s', time());
            DB::table('user_badges')->insert([
                'id' => null,
                'user_id' => $user_id,
                'badge_id' => $rank_id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }

    public function earn_rank($user_id,$rank_id) {
        $hasBadge = false;

        $user_ranks = DB::table('user_ranks')
                        ->where('user_id',$user_id)
                        ->select('user_ranks.badge_id')
                        ->get();

        foreach ($user_ranks as $user_rank) {
            if($user_rank->badge_id == $rank_id) {
                $hasBadge = true;
            }
        }

        if(!$hasBadge) {
            $date = date('Y/m/d h:i:s', time());
            DB::table('user_ranks')->insert([
                'id' => null,
                'user_id' => $user_id,
                'badge_id' => $rank_id,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
