<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AsesorAuthController extends Controller
{
    /**
     * Tampilkan form login asesor
     */
    public function loginForm()
    {
        if (Auth::check() && Auth::user()->role === 'asesor') {
            return redirect()->route('dashboard.asesor');
        }
        return view('auth.loginasesor');
    }

    /**
     * Proses login asesor dengan proteksi keamanan
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('role', 'asesor')
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            Log::channel('auth')->warning('Failed asesor login attempt', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password tidak sesuai']);
        }

        if (!$user->hasRole('asesor')) {
            $user->syncRoles(['asesor']);
        }

        Auth::login($user, $request->boolean('remember'));

        Log::channel('auth')->info('Asesor login successful', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'timestamp' => now(),
        ]);

        return redirect()->route('dashboard.asesor')
            ->with('success', 'Login berhasil. Selamat datang ' . $user->name);
    }

    /**
     * Logout asesor
     */
    public function logout(Request $request)
    {
        Log::channel('auth')->info('Asesor logout', [
            'user_id' => Auth::id(),
            'timestamp' => now(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('loginasesor')
            ->with('success', 'Logout berhasil');
    }
}
