<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate that either username or email is provided
        $request->validate([
            'password' => 'required|string|min:8|max:18',
        ]);

        // Check if username or email was provided
        $loginField = $request->filled('username') ? 'username' : 'email';
        $loginValue = $request->input($loginField);

        // Validate the specific field that was provided
        if (!$loginValue) {
            return back()->withErrors(['error' => 'Please provide either a username or email address.']);
        }

        Log::info('Login attempt:', [
            'login_field' => $loginField,
            'login_value' => $loginValue,
        ]);

        // Find user by username or email
        $user = User::where($loginField, $loginValue)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Log::info('Login successful:', [
                'user_id' => $user->id,
            ]);
            // Redirect to dashboard with user ID in query string
            return redirect()->route('registrant.dashboard', ['user_id' => $user->id]);
        }

        Log::warning('Login failed for ' . $loginField . ': ' . $loginValue);
        return back()->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }
}
