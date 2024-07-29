<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    // For the admin login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->role == 'admin') {
                if ($user->status == '1') {
                    if ($user && Hash::check($request->password, $user->password)) {
                        Auth::login($user);
                        return redirect()->route('admin.dashboard');
                    }
                } else {
                    return back()->withErrors([
                        'email' => 'You are the disabled by the super admin.',
                    ])->withInput($request->only('email'));
                }
            } else {
                if ($user && Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    return redirect()->route('admin.dashboard');
                }
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function SendEmail()
    {
        return view('admin.password.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $otp = rand(100000, 999999);
        DB::table('users')->updateOrInsert(['email' => $request->email], ['token' => $otp, 'created_at' => now()]);

        try {
            Mail::raw('Your OTP is ' . $otp, function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Your OTP');
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP.']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $otpRecord = DB::table('users')->where('token', $request->otp)->first();

        if ($otpRecord) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        $otpRecord = DB::table('users')->where('token', $request->otp)->first();

        if ($otpRecord) {
            $user = User::where('email', $otpRecord->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
