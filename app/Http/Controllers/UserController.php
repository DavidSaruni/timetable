<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Get all users except the current user
        $users = User::where('user_id', '!=', auth()->user()->user_id)->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        // generate unique username from name
        $base_username = strtolower(str_replace(' ', '', $request->name));
        $counter = 1;
        while (User::where('username', $base_username)->first()) {
            $base_username = $base_username . $counter;
            $counter++;
        }
        $user->username = $base_username;
        $user->password = bcrypt($base_username.'123');
        $user->role = 'user';
        $user->save();
        toastr()->success('User created successfully.');
        return redirect()->back();
    }
}
