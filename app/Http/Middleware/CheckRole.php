<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $arrRoles = explode("|", $role);
        if (!$request->user()->hasAnyRole($arrRoles)) {
            $objError = new \stdClass();
            $objError->message = __('custom.access_denied');
            $objError->status = 403;
            return response()->json($objError, $objError->status);
        }
        return $next($request);
    }
}
