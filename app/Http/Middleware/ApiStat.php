<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiStat
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \App\Models\ApiStat::query()->create([
            'user_id' => $request->user()->id,
            'api_name' => $request->route()->getName(),
        ]);

        return $next($request);
    }
}
