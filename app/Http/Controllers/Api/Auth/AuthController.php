<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){
            // for model App\Models\User
            $user = Auth::guard('web')->user();
            $info = [];
            $info['guard_name'] = 'user';
            $info['token'] = $user->createToken('MyApp')->plainTextToken;
            $info['name'] = $user->name;
            $info['auth_id'] = $user->id;
            $info['userData'] = $user;

            $response = [
                'success' => true,
                'data' => $info,
                'message' => 'User Login Successfully'
            ];
            return response()->json($response, 200);

        }else if(Auth::guard('netuser')->attempt(['email' => $request->email, 'password' => $request->password])){
            // for model App\Models\NetUser
            $user = Auth::guard('netuser')->user();
            $info = [];
            $info['guard_name'] = 'netuser';
            $info['token'] = $user->createToken('MyApp')->plainTextToken;
            $info['name'] = $user->name;
            $info['auth_id'] = $user->id;
            $info['userData'] = $user;

            $response = [
                'success' => true,
                'data' => $info,
                'message' => 'Net User Login Successfully'
            ];
            return response()->json($response, 200);

        }else{

            $response = [
                'success' => false,
                'message' => 'Unauthorised! User name or password was incorrect!'
            ];
            return response()->json($response);
        }
    }
}
