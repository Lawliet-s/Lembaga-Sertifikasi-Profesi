<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function sendResetLinkResponse(Request $request, $response)
    {
        Log::channel('auth')->info('Password reset link sent', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'timestamp' => now(),
        ]);

        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        Log::channel('auth')->warning('Password reset link request failed', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'reason' => trans($response),
            'timestamp' => now(),
        ]);

        return back()->withErrors(['email' => trans($response)]);
    }
}
