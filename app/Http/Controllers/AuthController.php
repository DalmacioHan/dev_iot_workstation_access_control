<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
    $credentials = $request->validate([
        'name' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()
        ->withErrors(['name' => 'Wrong username or password.'])
        ->withInput();
    }


    public function logout(Request $request){
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
    }
}
