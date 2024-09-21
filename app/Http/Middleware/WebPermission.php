<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Route;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;

class WebPermission
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
        $auth_user = getAuthUser($request);

        if( ! isset($auth_user->id)){

            if ($request->ajax()) {
                return response()->json(['status'=>'error', 'message'=>'Permission denied!']);
            }else{
                return redirect('/')->with('error', 'Permission denied!');
            }
        }

        return $next($request);
    }
}
