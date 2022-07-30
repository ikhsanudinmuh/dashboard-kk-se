<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage() {
        return view('auth.login');
    }

    public function registerPage() {
        return view('auth.register');
    }
    
    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            if (Auth::user() && Auth::user()->role == 'lecturer') {
                return redirect('/');
            } elseif (Auth::user() && Auth::user()->role == 'admin') {
                return redirect('/admin');
            }
        }

        return redirect('/login')->with('loginFailed', 'Login failed, Incorrect email or password');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'role' => 'required',
        ]);
    
        $hashedPassword = Hash::make($request->password);
        $request->merge([
            'password' => $hashedPassword,
        ]);
    
        $user = User::create($request->all());
    
        if ($user) {
            return redirect('/login')
                ->with('registerSuccess', 'Register success, login here');
        } else {
            return redirect('/register')
                ->with('registerFailed', 'Register failed');
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
