<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Router;
use App\Models\Address;
use App\Models\Arp;
use App\Models\NetUser;
use App\Models\ComplainSheet;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Recharge;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate_count = 10;
        $users = User::latest('id')->with(['role']);
        if ($request->search) {
            $users->where(function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
            $paginate_count = 20;
        }
        $users = $users->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $users,
            'message' => 'All User'
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // rule sometimes works only on field name is no present
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'password' => [
                'required',
                'confirmed',
                'min:8',             // must be at least 8 characters in length
                // 'regex:/[a-z]/',      // must contain at least one lowercase letter
                // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                // 'regex:/[0-9]/',      // must contain at least one digit
                // 'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        // get sanctum user data by token
        $auth_user = getAuthUser($request);

        try {
            $requests = $request->all();
            $requests['password'] = Hash::make($requests['password']);

            foreach ($requests as $key => $value) {
                // for multiple values array like checkbox
                if (is_array($value)) {
                    // convert to json string
                    $requests[$key] = json_encode($value);
                }
            }

            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $extension = $image->getClientOriginalExtension();
                $uploadDir = '/upload/profiles/';

                $destinationPath = public_path($uploadDir);

                $img_name = 'User-' . time() . '.' . $extension;
                $img = Image::make($image->getRealPath());
                $img->resize(200, 200)->save($destinationPath . '/' . $img_name);
                $requests['image'] = $uploadDir . $img_name;
            }

            $requests['authored_by'] = $auth_user->id;
            unset($requests['password_confirmation']);
            unset($requests['token']);
            $requests['type'] = 'user';

            if ($auth_user->type != 'superadmin') {
                // only superadmin can update user type
                unset($requests['type']);
            }

            $user = User::create($requests);
            $id = $user->id;
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed! ' . $e->getMessage() . ', Line:' . $e->getLine()], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'User Saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $response = [
            'status' => 'success',
            'data' => $user,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        $response = [
            'status' => 'success',
            'data' => $user,
            'message' => 'Single User'
        ];

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth_user = getAuthUser($request);

        if ($auth_user->type == 'superadmin' && $request->type == 'superadmin') {
            // if superadmin updates himself
            // rule sometimes works only on field name is no present
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'password' => [
                    'nullable',
                    'confirmed',
                    'min:8',             // must be at least 8 characters in length
                    // 'regex:/[a-z]/',      // must contain at least one lowercase letter
                    // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    // 'regex:/[0-9]/',      // must contain at least one digit
                    // 'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'status' => 'required',
                'password' => [
                    'nullable',
                    'confirmed',
                    'min:8',             // must be at least 8 characters in length
                    // 'regex:/[a-z]/',      // must contain at least one lowercase letter
                    // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    // 'regex:/[0-9]/',      // must contain at least one digit
                    // 'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            ]);
        }

        $save_data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'password' => $request->password,
            'status' => $request->status,
        ];

        $request->type ? ($save_data['type'] = $request->type) : null;

        if ($save_data['password'] == '') {
            unset($save_data['password']);
        } else {
            $save_data['password'] = Hash::make($save_data['password']);
        }

        if ($auth_user->type != 'superadmin') {

            // only superadmin can update user type of a user
            unset($save_data['type']);
        }

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $extension = $image->getClientOriginalExtension();
            $uploadDir = '/upload/profiles/';

            $destinationPath = public_path($uploadDir);
            // dd($destinationPath);
            $img_name = 'User-' . time() . '.' . $extension;
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200)->save($destinationPath . '/' . $img_name);
            $save_data['image'] = $uploadDir . $img_name;
        }

        // checkbox not updated on null requested
        $save_data['authored_by'] = $auth_user->id;

        User::find($id)->update($save_data);

        return response()->json(['status' => 'success', 'message' => 'User Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // echo '<pre>';print_r($id);
        User::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully!'
        ]);
    }

    public function dashboard()
    {
        $data['admin_users'] = User::count();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Dashboard Summary!'
        ]);
    }

    public function my_profile(Request $request)
    {
        $user = getAuthUser($request);

        $user = User::where('id', $user->id)->with(['role'])->first();

        $response = [
            'status' => 'success',
            'data' => $user,
            'message' => 'My User Profile'
        ];

        return response()->json($response);
    }

    public function my_profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => [
                'nullable',
                'confirmed',
                'min:8',             // must be at least 8 characters in length
                // 'regex:/[a-z]/',      // must contain at least one lowercase letter
                // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                // 'regex:/[0-9]/',      // must contain at least one digit
                // 'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        $save_data = [];
        // change only name, password and image
        $save_data['name'] = $request->name;
        $save_data['phone'] = $request->phone;

        if ($request->password) {
            $save_data['password'] = Hash::make($request->password);
        }

        if (request()->hasFile('image')) {
            $image = request()->file('image');
            $extension = $image->getClientOriginalExtension();
            $uploadDir = '/upload/profiles/';
            // if($_SERVER['HTTP_HOST'] == 'localhost')
            // {
            //     $destinationPath = public_path($uploadDir);
            // }else{
            //     $destinationPath = dirname(base_path()).$uploadDir;
            // }
            $destinationPath = public_path($uploadDir);
            $img_name = 'User-' . time() . '.' . $extension;
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200)->save($destinationPath . '/' . $img_name);
            $save_data['image'] = $uploadDir . $img_name;
        }

        $user = getAuthUser($request);

        User::find($user->id)->update($save_data);

        return response()->json(['status' => 'success', 'message' => 'Profile Updated successfully!'], 200);
    }
}
