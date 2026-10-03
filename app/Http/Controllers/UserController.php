<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.user.index', compact('users'));
    }
    public function create(){
        return view('admin.user.add');
    }
    public function store(Request $request){
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',

        ]);

        // Create a new user
        $user = new \App\Models\User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role = 'admin'; // Set a default role
        if (isset($validatedData['profile_picture'])) {
            $user->profile_picture = $validatedData['profile_picture']->store('profile_pictures', 'public');
        }
        $user->save();

        // Redirect to the users list with a success message
        return redirect()->route('user')->with('success', 'User created successfully.');
    }
    
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect to the users list with a success message
        return redirect()->route('user')->with('success', 'User deleted successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role'=>'required|string|in:super admin,admin',
        ]);

        // Update the user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        // Update the password only if it's provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Update the profile picture only if it's provided
        if (isset($validatedData['profile_picture'])) {
            $user->profile_picture = $validatedData['profile_picture']->store('profile_pictures', 'public');
        }
        $user->save();

        // Redirect to the users list with a success message
        return redirect()->route('user')->with('success', 'User updated successfully.');
    }
    public function show(User $user)
    {
        return view('admin.user.view', compact('user'));
    }
}
