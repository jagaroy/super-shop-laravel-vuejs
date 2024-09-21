<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate_count = 2;
        $categories = Category::latest('id');
        if ($request->search) {
            $categories->where(function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%');
            });
            $paginate_count = 2;
        }
        $categories = $categories->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $categories,
            'message' => 'All Category'
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
                'name' => 'required|unique:categories',

            ];
            $niceNames = [
                'name' => 'Name',

            ];
            Validator::make($requests, $rules, [], $niceNames)->validate();

            $requests['authored_by'] = $auth_user->id;
            unset($requests['id']);

            Category::create($requests);
        } catch (\Exception $e) {

            // return response()->json(['status' => 'error', 'message' => 'Failed! ' . $e->getMessage() . ', Line:' . $e->getLine()], 200);
            return response()->json(['status' => 'error', 'message' => 'Failed! An Error occured!'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Category Saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Category = Category::findOrFail($id);
        $response = [
            'status' => 'success',
            'data' => $Category,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Category = Category::find($id);

        $response = [
            'status' => 'success',
            'data' => $Category,
            'message' => 'Single Category'
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
            'name' => 'required|unique:categories,name,' . $id,

        ];
        $niceNames = [
            'name' => 'Name',

        ];
        Validator::make($requests, $rules, [], $niceNames)->validate();

        Category::find($id)->update($requests);

        return response()->json(['status' => 'success', 'message' => 'Category Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully!'
        ]);
    }
}
