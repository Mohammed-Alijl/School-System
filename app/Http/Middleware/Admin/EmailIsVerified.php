<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class EmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user('admin') ||
            ($request->user('admin') instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
                ! $request->user('admin')->hasVerifiedEmail())) {

            if ($request->expectsJson()) {
                return abort(403, 'Your email address is not verified.');
            }

            return Redirect::guest(URL::route('admin.verification.notice'));
        }

        return $next($request);
    }
}
