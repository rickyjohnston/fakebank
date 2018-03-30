<?php

namespace App\Http\Middleware;

use Closure;

class TransformOffset
{
    /**
     * If 'offset' exists instead of 'page', calculate page
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        if (isset($input['offset']) && isset($input['limit'])) {
            $input['page'] = ($input['offset'] / $input['limit']) + 1;

            $request->replace($input);
        }

        return $next($request);
    }
}
