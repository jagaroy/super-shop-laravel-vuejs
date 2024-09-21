<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NetUser;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Queue;
use App\Models\Recharge;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $paginate_count = 10;
        $roles = Role::latest('id');
        if($request->search){
            $roles->where(function($query) use($request) {

                $query->where('name', 'like', '%'. $request->search .'%')
                ->orWhere('description', 'like', '%'. $request->search .'%');
            });
            $paginate_count = 20;
        }
        $roles = $roles->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $roles,
            'message' => 'All Role'
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
			// 'description' => 'required',
        ]);

        $requests = $request->all();
        $role = Role::create($requests);

        $response = [
            'status' => 'success',
            'icon' => 'success',
            'success' => true,
            'message' => 'Role Added Successfully'
        ];

        return response()->json($response);
    }

    public function show(string $id)
    {
        $role = Role::find($id);

        if($role){

            $response = [
                'status' => 'success',
                'data' => $role,
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Role is not found!',
            ];
        }

        return response()->json($response, 200);

    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $response = [
            'status' => 'success',
            'data' => $role,
        ];

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
			// 'description' => 'required',
        ]);
        
        $info = [
            'name' => $request->name,
            'description' => $request->description,            
        ];
        $role = Role::findOrFail($id);
        $role->update($info);

        $response = [
            'status' => 'success',
            'message' => 'Role Updated Successfully'
        ];

        return response()->json($response);
    }

    public function destroy(String $id){

        // $recharge = Permission::where('role_id', $id)->first();
        // if($recharge){
        //     return response()->json([
        //         'status'=>'error',
        //         'message'=>'Sorry! Role is used for Permission already.'
        //     ]);
        // }

        // Role::destroy($id);

        // return response()->json([
        //     'status'=>'success',
        //     'message'=>'Role deleted successfully!'
        // ]);
    }

    public function role_list(Request $request)
    {
        $roles = Role::latest('id')->get();

        $response = [
            'status' => 'success',
            'data' => $roles,
            'message' => 'All Role'
        ];

        return response()->json($response, 200);
    }
    
}
