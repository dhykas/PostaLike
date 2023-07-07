<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }
    
    public function register(){
        return view('register');
    }

    public function logins(Request $req){
        $req->validate([            
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $req->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/'); 
        }
    
        // Authentication failed
        return redirect()->back(); 
    }

    public function registers(Request $req){
        $req->validate([
            'name' => 'required|unique:users,name|regex:/^[A-Za-z0-9_]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'name.regex' => 'The name may only contain alphabets, numbers, and underscores.',
        ]);
        
        User::create($req->all());
        $credentials = $req->only('email', 'password');

        Auth::attempt($credentials);

        return redirect()->route('index');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('index');

    }
}
