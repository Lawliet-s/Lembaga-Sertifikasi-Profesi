<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            Log::channel('auth')->warning('Account locked due to too many attempts', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $expectedRole = $request->input('role_login');

            if (
                ($expectedRole === 'asesi' && !$user->hasRole('asesi')) ||
                ($expectedRole === 'admin' && !$user->hasRole('admin'))
            ) {
                $this->guard()->logout();
                $this->incrementLoginAttempts($request);

                Log::channel('auth')->warning('Login failed - role mismatch', [
                    'email' => $request->input('email'),
                    'expected_role' => $expectedRole,
                    'actual_roles' => $user->getRoleNames(),
                    'ip' => $request->ip(),
                    'timestamp' => now(),
                ]);

                return $this->sendFailedLoginResponse($request);
            }

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            Log::channel('auth')->info('Login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->getRoleNames()->implode(', '),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        Log::channel('auth')->warning('Login failed - invalid credentials', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
        ]);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        Log::channel('auth')->info('User logout', [
            'user_id' => $user?->id,
            'email' => $user?->email,
            'ip' => $request->ip(),
            'timestamp' => now(),
        ]);

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin');
        }
        if ($user->hasRole('asesor')) {
            return redirect()->route('dashboard.asesor');
        }
        if ($user->hasRole('asesi')) {
            return redirect()->route('asesion');
        }
        return redirect()->route('/');
    }
}
