<?php

namespace App\Http\Middleware;

use Closure;

class StripEmptyStrings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->amount) && $request->amount === '') {
            unset($request->amount);
        }

        if (isset($request->date) && $request->date === '') {
            unset($request->date);
        }

        if (isset($request->customerId) && $request->customerId === '') {
            unset($request->customerId);
        }

        return $next($request);
    }
}
