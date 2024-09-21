<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NetUser;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Queue;
use App\Models\Recharge;
use App\Models\Role;
use Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Route as FacadeRoute;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $paginate_count = 200;
        $permissions = Permission::latest('permi_id');
        if($request->search){
            $permissions->where(function($query) use($request) {

                $query->where('name', 'like', '%'. $request->search .'%')
                ->orWhere('description', 'like', '%'. $request->search .'%');
            });
            $paginate_count = 20;
        }
        $permissions = $permissions->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $permissions,
            'message' => 'All Permission'
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
			// 'description' => 'required',
        ]);

        Permission::where(['role_id'=>$request->role_id])->delete();

        if ($request->module) {
            
            foreach ($request->module as $key => $value) {
                $store = [];
                $desc = [];
                foreach ($request->module_sub[$key] as $key_desc => $value_desc) {
                    $desc[] = $key_desc;                
                }
                $store['role_id'] = $request->role_id;
                $store['permi_module'] = $key;
                $store['permi_desc'] = json_encode($desc);

                Permission::create($store);
            }
        }

        $response = [
            'status' => 'success',
            'icon' => 'success',
            'success' => true,
            'message' => 'Permission Added Successfully'
        ];

        return response()->json($response);
    }

    public function show(string $id)
    {
        $permission = Permission::find($id);

        if($permission){

            $response = [
                'status' => 'success',
                'data' => $permission,
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Permission is not found!',
            ];
        }

        return response()->json($response, 200);

    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        $response = [
            'status' => 'success',
            'data' => $permission,
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
        $permission = Permission::findOrFail($id);
        $permission->update($info);

        $response = [
            'status' => 'success',
            'message' => 'Permission Updated Successfully'
        ];

        return response()->json($response);
    }

    public function destroy(String $id){

        // $recharge = Permission::where('permission_id', $id)->first();
        // if($recharge){
        //     return response()->json([
        //         'status'=>'error',
        //         'message'=>'Sorry! Permission is used for Permission already.'
        //     ]);
        // }

        // Permission::destroy($id);

        // return response()->json([
        //     'status'=>'success',
        //     'message'=>'Permission deleted successfully!'
        // ]);
    }

    public function getPermissionList(Request $request)
    {        
        $data = [];
        $data['role_permissions'] = [];
        if ($request->role_id) {
            $data['role_permissions'] = Permission::leftJoin('roles', 'roles.id', '=', 'permissions.role_id')->where('permissions.role_id', $request->role_id)->select('permissions.*', 'roles.name')->get();

            // echo '<pre>'; dd($data['role_permissions']); echo '</pre>';
        }

        $routeCollection = FacadeRoute::getRoutes();

        $info = [];
        foreach ($routeCollection as $value) {
            $dat = json_decode( json_encode($value), true)['action'];

            $uses = isset($dat['uses']) ? $dat['uses'] : 'n/a';
            if( is_array($uses) || strpos($uses, 'App\Http\Controllers') === false){
                continue;
            }

            $uses = str_replace('App\Http\Controllers\\', '', $uses);
            $uses = str_replace('Auth\\', '', $uses);
            $uses = str_replace('Controller', '', $uses);
            $info[] = $uses;
        }

        foreach ($info as $key => $value) {
            if ( ! $value) {                
                unset($info[$key]);
            }
        }

        $exceptControllers = ['ConfirmPassword', 'ForgotPassword', 'Login', 'Register', 'ResetPassword', 'Verification'];

        $modules = [];
        foreach ($info as $key => $value) {
            
            $controller =  explode('@', $value)[0];

            $action = explode('@', $value)[1];

            if ( ! in_array($controller, $modules) && ! in_array($controller, $exceptControllers)) {

                $modules[] = $controller;
            }
        }

        $module_permissions = [];
        foreach ($modules as $key_module => $value_module) {

            $ddd = [];
            foreach ($info as $key_info => $value_info) {
                if ( explode('@', $value_info)[0] == $value_module) {

                    // $ddd[] = str_replace('_', ' ', implode(' ', preg_split('/(?=[A-Z])/', explode('@', $value_info)[1] )) );

                    $ddd[] = explode('@', $value_info)[1];
                }
            }

            $module_permissions[$key_module]['name_title'] = str_replace('_', '', implode(' ', preg_split('/(?=[A-Z])/', $value_module )) );
            $module_permissions[$key_module]['name'] = $value_module;

            $module_permissions[$key_module]['data'] = array_unique($ddd);
        }

        $data['modules'] = $modules;
        $data['module_permissions'] = $module_permissions;
        $data['info'] = array_unique($info);

        $data['roles'] = Role::orderBy('id', 'asc')->get();
        $data['permissions'] = Permission::orderBy('permi_id', 'desc')->latest()->get();

        $html = "";
        if($request->role_id){

            //render starts
            $html .= '
                    <input type="hidden" name="permission" value="1" />
                    <input type="hidden" name="role_id" value="'. $request->role_id .'" />
                    <div class="text-end p-2">
                        <button class="btn btn-sm btn-success" type="submit">
                            Save Permission
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Branch">
                            <thead>
                                <tr>
                                    <th width="2%">
                                        SL
                                    </th>
                                    <th width="14%">
                                        Module
                                    </th>
                                    <th width="85%">
                                        Permissions
                                    </th>
                                    <th width="5%">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>';
                                if (isset($data["module_permissions"])){

                                    foreach ($data["module_permissions"] as $key => $module){
                                        $html .= '
                                        <tr data-entry-id="">
                                            <td>
                                                '. $key + 1 .'
                                            </td>
                                            <td>
                                                <strong>'. $module["name_title"] .'</strong>
                                                <input class="module" type="checkbox"
                                                    name="module['. $module["name"] .']"
                                                    '. (moduleExist($data["role_permissions"], $module["name"]) ? 'checked' : '') .' />
                                            </td>
                                            <td>';

                                                foreach ($module['data'] as $key_info => $key_value) {
                                                    $html .= '
                                                    <input class="module_sub_class" type="checkbox"
                                                        name="module_sub['. $module['name'] .']['. $key_value .']"
                                                        '. (actionExist($data["role_permissions"], $module['name'], $key_value) ? 'checked' : '') .' />

                                                    <label
                                                        for="module_sub['. $module['name'] .']['. $key_value .']">
                                                        '. $key_value .' &nbsp; &nbsp; &nbsp;
                                                    </label>';
                                                }
            $html .= '
                                            </td>
                                            <td>

                                            </td>

                                        </tr>';
                                        
                                    }
                                }
                            $html .= '
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group text-center p-2">
                        <button class="btn btn-sm btn-success" type="submit">
                            Save Permission
                        </button>
                    </div>
            ';
            //render ends
        }

        $data['html'] = $html;

        $response = [
            'status' => 'success',
            'data' => $data,
            'message' => 'All Permission'
        ];

        return response()->json($response, 200);
    }
    
}
