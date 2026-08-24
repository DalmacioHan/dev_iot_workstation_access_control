<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.account.index', compact('user'));
    }

    public function sendCode(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $code = (string) random_int(100000, 999999);

        try {
            $user->forceFill([
                'reset_code' => $code,
            ])->save();

            Mail::to($validated['email'])->send(new PasswordResetCode($code));

            return response()->json([
                'message' => 'Verification code sent successfully.',
            ]);
        } catch (\Throwable $throwable) {
            $user->forceFill([
                'reset_code' => null,
            ])->save();

            report($throwable);

            return response()->json([
                'message' => 'Unable to send verification code.',
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'verification_code' => 'nullable|digits:6',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'verification_code' => 'required|digits:6',
            ]);

            if ((string) $user->reset_code !== (string) $request->verification_code) {
                return back()
                    ->withErrors(['verification_code' => 'The verification code is invalid.'])
                    ->withInput();
            }
        }

        $user->name = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->reset_code = null;
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Account updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}