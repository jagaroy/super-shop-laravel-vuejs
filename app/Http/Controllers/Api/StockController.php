<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate_count = 2;
        $stocks = Stock::with('product')->latest('id');
        if ($request->search) {
            $stocks->where(function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%');
            });
            $paginate_count = 2;
        }
        $stocks = $stocks->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $stocks,
            'message' => 'All Stock'
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

    // multiple insert to stock
    public function store(Request $request)
    {
        // get sanctum user data by token
        $auth_user = getAuthUser($request);

        $requests = $request->except(['_token']);

        $rules = [
            'product_id'   => 'required|array|min:1',
            'product_id.*' => 'required|integer',
            'quantity'     => 'required|array|min:1',
            'quantity.*'   => 'required|integer',
        ];
        $niceNames = [
            'product_id' => 'Product',
			'quantity' => 'Quantity',
        ];
        Validator::make($requests, $rules, [], $niceNames)->validate();

        try {
            DB::beginTransaction();
            foreach ($requests['product_id'] as $key => $product_id) {

                $save_data = [];

                $stock = Stock::where('product_id', $product_id)->first();
                if($stock){
                    $update_data = [
                        'quantity' => $stock->quantity + $requests['quantity'][$key]
                    ];
                    $stock->update($update_data);
                }else{
                    $save_data['product_id'] = $requests['product_id'][$key];
                    $save_data['quantity'] = $requests['quantity'][$key];
                    $save_data['authored_by'] = $auth_user->id;
                    Stock::create($save_data);
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error', 'message'=>'Stock Saving failed!'], 200);
        }

        return response()->json(['status'=>'success', 'message'=>'Stock Saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Stock = Stock::findOrFail($id);
        $response = [
            'status' => 'success',
            'data' => $Stock,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Stock = Stock::find($id);

        $response = [
            'status' => 'success',
            'data' => $Stock,
            'message' => 'Single Stock'
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
            'product_id' => 'Product',
            'quantity' => 'Quantity',

        ];
        Validator::make($requests, $rules, [], $niceNames)->validate();

        Stock::find($id)->update($requests);

        return response()->json(['status' => 'success', 'message' => 'Stock Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Stock::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Stock deleted successfully!'
        ]);
    }
}
