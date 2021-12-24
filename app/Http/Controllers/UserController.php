<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

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
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }
        return back()->withInput()->with('status', 'Invalid login details!');
    }

    //User Views START
    public function dashboard_users($users=null,$title="User"){
        $users = $users ?? User::paginate(15);
        return view('admin.users',['data_name'=>$title,'users'=>$users]);
    }

    public function dashboard_view_students(){
        $users = User::role('student')->paginate(15);
        return $this->dashboard_users($users,"Student");
    }

    public function dashboard_view_instructors(){
        $users = User::role('instructor')->paginate(15);
        return $this->dashboard_users($users, "Instructor");
    }
    //User Views END

}
