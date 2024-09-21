<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate_count = 2;
        $sub_categories = SubCategory::with('category')->latest('id');
        if ($request->search) {
            $sub_categories->where(function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%');
            });
            $paginate_count = 2;
        }
        $sub_categories = $sub_categories->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $sub_categories,
            'message' => 'All Sub Category'
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
                'category_id' => 'required',
                'name' => 'required',

            ];
            $niceNames = [
                'category_id' => 'Category',
                'name' => 'Name',

            ];
            Validator::make($requests, $rules, [], $niceNames)->validate();

            $requests['authored_by'] = $auth_user->id;
            unset($requests['id']);

            SubCategory::create($requests);
        } catch (\Exception $e) {

            // return response()->json(['status' => 'error', 'message' => 'Failed! ' . $e->getMessage() . ', Line:' . $e->getLine()], 200);
            return response()->json(['status' => 'error', 'message' => 'Failed! An Error occured!'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Sub Category Saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Sub_Category = SubCategory::findOrFail($id);
        $response = [
            'status' => 'success',
            'data' => $Sub_Category,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Sub_Category = SubCategory::find($id);

        $response = [
            'status' => 'success',
            'data' => $Sub_Category,
            'message' => 'Single Sub Category'
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
        $rules = [];
        $niceNames = [
            'category_id' => 'Category',
            'name' => 'Name',

        ];
        Validator::make($requests, $rules, [], $niceNames)->validate();

        SubCategory::find($id)->update($requests);

        return response()->json(['status' => 'success', 'message' => 'Sub Category Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SubCategory::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub Category deleted successfully!'
        ]);
    }
}
