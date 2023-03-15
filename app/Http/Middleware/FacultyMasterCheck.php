<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AppBaseController;
use App\Http\Utils\ResponseUtils;
use App\Http\Utils\RoleUtils;
use Closure;
use Illuminate\Support\Facades\Auth;

class FacultyMasterCheck extends AppBaseController
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
        $user = Auth::user();
        if(!$user->role == RoleUtils::ROLE_QUAN_LY_KHOA){
            return $this->sendError(__('auth.unAuthorized'), ResponseUtils::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
