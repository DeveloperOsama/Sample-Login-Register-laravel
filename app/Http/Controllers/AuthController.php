<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $credential = $request->only('email', 'password');

        if (Auth::attempt($credential)){
            return redirect()->intended(route("home"));
        }
        return redirect(route("login"))->with("error", "Login failed");
    }
    public function register()
    {
        return view('auth.register');
    }

    function registerPost(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required",
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route("login"))->with("success", "User Created Successfully");
    }
    return redirect(route("register"))->with("error", "User Registration Failed");
  }
}
