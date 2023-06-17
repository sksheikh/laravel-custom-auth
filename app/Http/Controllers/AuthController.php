<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function register()
    {
        // dd('hello');
        return view('auth.register');
    }

    public function userRegister(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email ',
            'phone' => 'required|unique:users|numeric|digits:11 ',
            'password' => 'required|confirmed'
        ]);

        // dd($request->all());
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $credentials =  $request->only('email','password');

        // Auth::login($user);
        if( Auth::attempt($request->only('email','password')) || Auth::attempt($request->only('phone','password'))){
            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function userLogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email',$request->user_name)->orWhere('phone',$request->user_name)->first();
        // // dd($user);
        if($user && Hash::check($request->password, $user->password)){
            Auth::login($user);
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors('Login failed');
    }

    public function logout()
    {
        // dd('hello');
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }
}
