<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Honeypot
{
    private string $fieldName = '_hp';
    private string $timeField = '_hpt';

    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            if ($this->isSpam($request)) {
                return $this->spamResponse();
            }
        }

        return $next($request);
    }

    private function isSpam(Request $request): bool
    {
        if ($request->has($this->fieldName) && !empty($request->input($this->fieldName))) {
            return true;
        }

        if ($request->has($this->timeField)) {
            $loadedAt = (int) $request->input($this->timeField);
            $now = time();
            $elapsed = $now - $loadedAt;

            if ($elapsed < 1) {
                return true;
            }
        }

        return false;
    }

    private function spamResponse()
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => 'OK'], 200);
        }
        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
}
