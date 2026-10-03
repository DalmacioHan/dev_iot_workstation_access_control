<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
class ForgotPasswordController extends Controller 
{
     /** * Send the password reset link. */
    public function index(){
         return view('auth.forgot-password');
    }
    public function sendResetLink(Request $request)
        { $request->validate([ 'email' => ['required', 'email'], ]);
        $status = Password::sendResetLink( $request->only('email') );
        if ($status === Password::RESET_LINK_SENT) 
            { 
                return back()->with( 'status', 'We have emailed your password reset link.' ); 
            } 
            return back() ->withInput($request->only('email')) ->withErrors([ 'email' => __($status), ]); 
        } 
            
            
}
