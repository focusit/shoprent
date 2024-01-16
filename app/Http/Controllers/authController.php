<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            $errorMessage = 'Invalid email.';
        } elseif ($user->password !== $credentials['password']) {
            $errorMessage = 'Invalid password.';
        } elseif (!$user->isAdmin()) {
            $errorMessage = 'Unauthorized. Please login as an admin.';
        } else {
            Auth::login($user);
            return redirect()->route('dashboard')->with('info', 'You have successfully logged in as an admin.');
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->onlyInput('email');
    }




    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
