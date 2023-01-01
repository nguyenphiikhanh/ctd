<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AppBaseController;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApiV1Auth extends AppBaseController
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
        if(!Auth::check()){
            return $this->sendError(__('auth.unAuthenticated'),Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
