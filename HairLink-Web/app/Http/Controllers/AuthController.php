<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $redirectUrl = '/donor/dashboard';
            if ($user->role === 'recipient') {
                $redirectUrl = '/recipient/dashboard';
            } elseif ($user->role === 'admin') {
                $redirectUrl = '/admin';
            }

            if ($request->expectsJson()) {
                return response()->json(['redirect' => $redirectUrl]);
            }
            return redirect()->intended($redirectUrl);
        }

        if ($request->expectsJson()) {
            return response()->json(['errors' => ['email' => ['The provided credentials do not match our records.']]], 422);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'userType' => ['required', Rule::in(['donor', 'recipient'])],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'role' => $validated['userType'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'country' => $validated['country'],
            'region' => $validated['region'],
            'postal_code' => $validated['postal_code'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        $redirectUrl = $user->role === 'recipient' ? '/recipient/dashboard' : '/donor/dashboard';

        if ($request->expectsJson()) {
            return response()->json(['redirect' => $redirectUrl]);
        }

        return redirect($redirectUrl);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
