<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Route;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;

class Permission
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
        $method = $request->method();

        // for readonly. not complete solution. add restriction on model/db for complete solution.
        // if($method=="DELETE"){
        //     return response()->json(['status'=>'error', 'message'=>'Delete option is disabled for demo!']);
        // }elseif($method=="PUT"){
        //     return response()->json(['status'=>'error', 'message'=>'Edit option is disabled for demo!']);
        // }

        // $token= $request->header('Authorization');
        // $token = PersonalAccessToken::findToken($token);
        // $auth_user = $token ? $token->tokenable : null;

        // if( ! $auth_user){
        //     return response()->json(['status'=>'error', 'message'=>'Authorization token is missing!']);
        // }
        
        // if ($auth_user->email == 'demo@demo.com' ) {
        //     $method = $request->method();
        //     if ($method == 'GET') {
        //         return $next($request);
        //     }else{
        //         return response()->json(['status'=>'error', 'message'=>'Permission denied!']);
        //     }
        // }else{

        //     return $next($request);
        // }

        $route = Route::getRoutes()->match($request);
        $currentroute = explode('@', class_basename($route->getActionName()) );
        $controller = $currentroute[0];
        $method = $currentroute[1];
        
        $auth_user = getAuthUser($request);
        if( ! isset($auth_user->id)){
            return response()->json($auth_user);
        }
        $permission = hasPermission($auth_user, $controller, $method);
        if ( ! $permission ) {
            return response()->json(['status'=>'error', 'message'=>'Permission denied!']);
            // if ($request->ajax()) {
            //     return response()->json(['status'=>'error', 'message'=>'Permission denied!']);
            // }else{
            //     return redirect('/')->with('error', 'Permission denied!');
            // }
        }
        return $next($request);
    }
}
