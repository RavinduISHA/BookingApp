<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(){
        return view('auth.register');
    }

    public function login(){
        return view('auth.login');
    }

    public function store(Request $request){
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6'
        ]);

        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect('/login')->with('success', 'User Successfully Registered!');
    }

    public function loginToUser(Request $request){
        $request-> validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        $credentails = $request->only('email', 'password');
        if(Auth::attempt($credentails)){
            return redirect('/home')->with('success', "Loging Success");
        } else {
            return redirect('/login')->with('error', 'Credentilas Invalid');
        }
    }
}
