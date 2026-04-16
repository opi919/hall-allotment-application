<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::where('key', 'allow_application')->first();
        if (!$setting || $setting->value !== '1') {
            abort(403, 'Applications are currently not allowed.');
        }
        return $next($request);
    }
}
