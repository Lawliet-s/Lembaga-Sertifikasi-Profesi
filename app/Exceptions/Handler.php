<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldLogApiError($e)) {
                $this->logApiError($e);
            }

            if ($this->shouldReportToSlack($e)) {
                Log::channel('slack')->critical($e->getMessage(), [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'url' => request()?->fullUrl(),
                    'method' => request()?->method(),
                    'ip' => request()?->ip(),
                    'timestamp' => now(),
                ]);
            }
        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {
            Log::channel('security')->warning('Rate limit exceeded', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terlalu banyak permintaan. Silakan coba lagi nanti.',
                ], 429);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Resource tidak ditemukan.',
                ], 404);
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                ], 401);
            }
        });
    }

    protected function shouldLogApiError(Throwable $e): bool
    {
        if ($e instanceof ThrottleRequestsException ||
            $e instanceof AuthenticationException) {
            return false;
        }

        return true;
    }

    protected function logApiError(Throwable $e): void
    {
        $context = [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];

        if (request()) {
            $context['request'] = [
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ];
        }

        if ($e->getPrevious()) {
            $context['previous'] = get_class($e->getPrevious());
        }

        Log::channel('api')->error('Application error', $context);
    }

    protected function shouldReportToSlack(Throwable $e): bool
    {
        if (!env('LOG_SLACK_WEBHOOK_URL')) {
            return false;
        }

        if ($e instanceof NotFoundHttpException ||
            $e instanceof ThrottleRequestsException ||
            $e instanceof AuthenticationException) {
            return false;
        }

        return $e instanceof HttpException && $e->getStatusCode() >= 500;
    }
}
