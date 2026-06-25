<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecurityLogger
{
    private $suspiciousPaths = [
        '.env', 'wp-admin', 'wp-content', 'admin.php',
        'phpmyadmin', 'phpMyAdmin', 'mysql', 'sql',
        'backup', 'dump', 'db_backup', 'xmlrpc.php',
        'wp-login.php', 'server-status', 'cgi-bin',
        '.git/config', '.svn', 'vendor/phpunit',
        'artisan', 'console', 'shell',
    ];

    private $suspiciousUserAgents = [
        'curl', 'wget', 'python-requests', 'go-http-client',
        'scrapy', 'masscan', 'nmap', 'sqlmap',
        'nikto', 'wpscan', 'openvas', 'nessus',
        'acunetix', 'burp', 'zap',
    ];

    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();

        if ($this->isSuspiciousPath($path)) {
            Log::channel('security')->warning('Suspicious path access attempt', [
                'path' => $path,
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'query' => $request->query(),
                'timestamp' => now(),
            ]);
        }

        if ($this->isSuspiciousUserAgent($request->userAgent())) {
            Log::channel('security')->warning('Suspicious user agent detected', [
                'user_agent' => $request->userAgent(),
                'path' => $path,
                'ip' => $request->ip(),
                'method' => $request->method(),
                'timestamp' => now(),
            ]);
        }

        if ($request->isMethod('post') && !$request->ajax() && !$request->wantsJson()) {
            $this->logUnusualTraffic($request);
        }

        return $next($request);
    }

    private function isSuspiciousPath(string $path): bool
    {
        foreach ($this->suspiciousPaths as $suspicious) {
            if (str_contains($path, $suspicious)) {
                return true;
            }
        }

        if (preg_match('/\.(php\d?|sql|bak|old|swp|env)$/i', $path)) {
            return true;
        }

        return false;
    }

    private function isSuspiciousUserAgent(?string $agent): bool
    {
        if (!$agent) {
            return true;
        }

        $agentLower = strtolower($agent);

        foreach ($this->suspiciousUserAgents as $suspicious) {
            if (str_contains($agentLower, $suspicious)) {
                return true;
            }
        }

        return false;
    }

    private function logUnusualTraffic(Request $request): void
    {
        $ip = $request->ip();
        $cacheKey = 'traffic_count_' . $ip;
        $window = 60;
        $threshold = 60;

        $count = cache()->remember($cacheKey, $window, function () {
            return 0;
        });

        cache()->increment($cacheKey);

        if ($count >= $threshold && $count % 10 === 0) {
            Log::channel('security')->warning('High traffic volume detected from single IP', [
                'ip' => $ip,
                'request_count' => $count,
                'window_seconds' => $window,
                'last_path' => $request->path(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);
        }
    }
}
