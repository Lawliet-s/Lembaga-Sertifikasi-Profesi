<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BotDetector
{
    private array $badBots = [
        'ahrefsbot', 'semrushbot', 'majestic-12', 'dotbot',
        'dataforseobot', 'blexbot', 'netsystemsresearch', 'claudebot',
        'purebot', 'mj12bot', 'serpstatbot', 'linkpadbot',
        'coccocbot', 'admantx', 'yandexbot', 'baiduspider',
        'sogou', 'exabot', 'ia_archiver', 'pagesinventory',
        '80legs', 'netspider', 'blackwidow', 'nikto',
        'zgrab', 'python-requests', 'python-urllib', 'curl',
        'wget', 'scrapy', 'masscan', 'whatweb',
        'acunetix', 'burpsuite', 'sqlmap', 'nmap',
        'nessus', 'openvas', 'w3af', 'appscan',
        'arachni', 'netsparker', 'wpscan', 'joomscan',
    ];

    public function handle(Request $request, Closure $next)
    {
        if ($this->isBot($request)) {
            Log::channel('security')->warning('Bot detected and blocked', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'timestamp' => now(),
            ]);
            return $this->botResponse();
        }

        if ($this->isRapidFire($request)) {
            return $this->botResponse();
        }

        return $next($request);
    }

    private function isBot(Request $request): bool
    {
        $ua = strtolower($request->userAgent() ?? '');

        if (empty($ua)) {
            return $request->isMethod('post');
        }

        foreach ($this->badBots as $bot) {
            if (str_contains($ua, $bot)) {
                return true;
            }
        }

        return false;
    }

    private function isRapidFire(Request $request): bool
    {
        if ($request->isMethod('get')) {
            return false;
        }

        $ip = $request->ip();
        $cacheKey = 'rapid_fire:' . $ip;
        $threshold = 20;
        $window = 10;

        $count = Cache::get($cacheKey, 0);
        $count++;

        Cache::put($cacheKey, $count, now()->addSeconds($window));

        if ($count > $threshold) {
            Log::channel('security')->warning('Rapid-fire request blocked', [
                'ip' => $ip,
                'count' => $count,
                'window' => $window . 's',
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'timestamp' => now(),
            ]);
            return true;
        }

        return false;
    }

    private function botResponse()
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        abort(403, 'Akses ditolak.');
    }
}
