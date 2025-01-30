<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.user-mangement.index', compact('users'));
    }
    public function create()
    {
        return view('admin.user-mangement.create');
    }

    public function store(Request $request)
    {
        // Validate input with uniqueness for the email field
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => 'The email address is already in use. Please use a different one.',
            'password.min' => 'The password must be at least 6 characters long.',
        ]);

        try {
            // Create a new user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            // Redirect with success message
            return redirect()->route('admin.user.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error creating user: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->withErrors('An error occurred while creating the user. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate input (excluding password)
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,' . $id, // Ensure email is unique except for this user
        ], [
            'email.unique' => 'The email address is already in use. Please use a different one.',
        ]);

        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Update the user details (except password)
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            // Save the updated user
            $user->save();

            // Redirect with success message
            return redirect()->route('admin.user.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error updating user: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->withErrors('An error occurred while updating the user. Please try again.');
        }
    }



    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user-mangement.edit', compact('user'));
    }

    public function resetPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-mangement.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            // Find the user
            $user = User::findOrFail($id);

            // Update the password
            $user->password = bcrypt($request->password);
            $user->save();

            // Redirect back with a success message
            return redirect()->route('admin.user.index')->with('success', 'Password reset successfully.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error resetting password: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors('An error occurred while resetting the password. Please try again.');
        }
    }
}
