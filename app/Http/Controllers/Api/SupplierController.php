<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate_count = 2;
        $suppliers = Supplier::latest('id');
        if ($request->search) {
            $suppliers->where(function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%');
            });
            $paginate_count = 2;
        }
        $suppliers = $suppliers->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $suppliers,
            'message' => 'All Supplier'
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
        // get sanctum user data by token
        $auth_user = getAuthUser($request);

        try {

            $requests = $request->except(['_token', 'token']);
            $rules = [
                'supplier_name' => 'required',
                'phone' => 'required|unique:suppliers',

            ];
            $niceNames = [
                'supplier_name' => 'Supplier Name',
                'phone' => 'Phone',

            ];
            Validator::make($requests, $rules, [], $niceNames)->validate();

            $requests['authored_by'] = $auth_user->id;
            unset($requests['id']);

            Supplier::create($requests);
        } catch (\Exception $e) {

            // return response()->json(['status' => 'error', 'message' => 'Failed! ' . $e->getMessage() . ', Line:' . $e->getLine()], 200);
            return response()->json(['status' => 'error', 'message' => 'Failed! An Error occured!'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Supplier Saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Supplier = Supplier::findOrFail($id);
        $response = [
            'status' => 'success',
            'data' => $Supplier,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Supplier = Supplier::find($id);

        $response = [
            'status' => 'success',
            'data' => $Supplier,
            'message' => 'Single Supplier'
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

        $requests = $request->except(['_token', 'token']);
        $rules = [
            'phone' => 'required|unique:suppliers,phone,' . $id,

        ];
        $niceNames = [
            'supplier_name' => 'Supplier Name',
            'phone' => 'Phone',

        ];
        Validator::make($requests, $rules, [], $niceNames)->validate();

        Supplier::find($id)->update($requests);

        return response()->json(['status' => 'success', 'message' => 'Supplier Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Supplier deleted successfully!'
        ]);
    }
}
