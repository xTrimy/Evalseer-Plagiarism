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
        $users = User::role('student')->paginate(15);
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
        return view('admin.view-assignments',['users'=>$users,'assignments'=>$assignments]);
    }

    public function view_assignment_questions($assignment_id) {
        // dd($assignment_id);
        $users = User::role('instructor')->paginate(15);

        $questions = DB::table('questions')
                        ->where('assignment_id',$assignment_id)
                        ->select('questions.*')
                        ->get();
        return view('admin.view-assignments-questions',['users'=>$users,'questions'=>$questions]);
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

                        // dd($submissions);
        return view('admin.view-question-submissions',['users'=>$users,'submissions'=>$submissions,'question_id'=>$question_id]);
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

        return view('admin.view-submission',['users'=>$users,'submissions'=>$submissions]);
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
        return view('admin.edit-submission',['users'=>$users,'submissions'=>$submissions]);
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

        $assignments = Assignments::get();
        $assignments = count($assignments);

        $submissions = Submission::get();
        $submissions = count($submissions);


        return view('instructor.index',["users"=>$users,"assignments"=>$assignments,"submissions"=>$submissions]);
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
