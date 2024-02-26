<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_admin) {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized. Please login as an admin.'])->onlyInput('email');
            }
            // toastr()->addSuccess('Your account has been restored.');
            return redirect()->route('dashboard')->with('info', 'You have successfully logged in as an admin.');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    //Registeration 
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showProfile()
    {
        return view('auth.profile');
    }
    public function register(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'is_admin' => 'boolean',
        ];

        // Validation messages
        $messages = [
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        // Redirect to login page or any other page after registration
        return redirect('/');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
        ]);

        $user = Auth::user();

        // Check if the provided current password matches the user's current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Check if the old password and new password are the same
        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'The new password should be different from the current password.']);
        }

        // Update the user's password using the User model
        $user->password = bcrypt($request->new_password);
        User::where('id', $user->id)->update([
            'password' => bcrypt($request->new_password),
        ]);


        return redirect()->route('profile')->with('success', 'Password updated successfully.');
    }
}
