<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Show the register page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function register(RegisterRequest $request)
        {
            $user = User::create($request->validated());
            $user->role = User::ROLE_USER;
            $user->save();

            auth()->login($user);

            toastr()->success('Welcome, ' . $user->name);

            return redirect()->route('home');
        }
}
