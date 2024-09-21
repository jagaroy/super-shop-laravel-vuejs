<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginate_count = 2;
        $products = Product::with(['category', 'sub_category', 'supplier', 'brand'])->latest('id');
        if ($request->search) {
            $products->where(function ($query) use ($request) {

                $query->where('name', 'like', '%' . $request->search . '%');
                $query->orWhereHas('supplier', function ($query) use ($request) {
                    $query->where('supplier_name', 'like', '%' . $request->search . '%');
                });
                $query->orWhereHas('brand', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
                $query->orWhereHas('category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
                $query->orWhereHas('sub_category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        $products = $products->paginate($paginate_count);

        $response = [
            'status' => 'success',
            'data' => $products,
            'message' => 'All Product'
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
                'name' => 'required|unique:products',
                'sub_category_id' => 'required',
                'unit_type' => 'required',
                'retail_price_per_unit' => 'required',
                // 'sku' => 'required',

            ];
            $niceNames = [
                'name' => 'Name',
                'sub_category_id' => 'Sub Category',
                'unit_type' => 'Unit Type',
                'retail_price_per_unit' => 'Retail Price Per Unit',
                'sku' => 'SKU',

            ];
            Validator::make($requests, $rules, [], $niceNames)->validate();

            if (request()->hasFile("product_image")) {
                $image = request()->file("product_image");
                $extension = $image->getClientOriginalExtension();
                $uploadDir = "/upload/products/";
                if (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
                    $destinationPath = public_path($uploadDir);
                } else {
                    // for cpanel linux
                    $destinationPath = dirname(base_path()) . $uploadDir;
                }
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath);
                }
                $img_name = "product_image-" . uniqid() . "." . $extension;
                // $img = Image::make($image->getRealPath());
                // $img->resize(768, 432)->save($destinationPath."/". $img_name);
                // another approach if Image class not functioning
                $request->product_image->move($destinationPath, $img_name);
                $requests["product_image"] = $uploadDir . $img_name;
            }

            $requests['authored_by'] = $auth_user->id;
            $requests['sku'] = 999;
            unset($requests['id']);
            unset($requests['image']);

            Product::create($requests);
        } catch (\Exception $e) {

            // return response()->json(['status' => 'error', 'message' => 'Failed! ' . $e->getMessage() . ', Line:' . $e->getLine()], 200);
            return response()->json(['status' => 'error', 'message' => 'Failed! An Error occured!'], 200);
        }

        return response()->json(['status' => 'success', 'message' => 'Product Saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Product = Product::findOrFail($id);
        $response = [
            'status' => 'success',
            'data' => $Product,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Product = Product::find($id);

        $response = [
            'status' => 'success',
            'data' => $Product,
            'message' => 'Single Product'
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
            'name' => 'required|unique:products,name,' . $id,

        ];
        $niceNames = [
            'name' => 'Name',
            'sub_category_id' => 'Sub Category',
            'unit_type' => 'Unit Type',
            'retail_price_per_unit' => 'Retail Price Per Unit',
            'sku' => 'SKU',

        ];
        Validator::make($requests, $rules, [], $niceNames)->validate();
        foreach ($requests as $key => $value) {
            // for multiple values array like checkbox
            if (is_array($value)) {
                // convert to json string
                $requests[$key] = json_encode($value);
            }
        }
        if (request()->hasFile("product_image")) {
            $image = request()->file("product_image");
            $extension = $image->getClientOriginalExtension();
            $uploadDir = "/upload/products/";
            if (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
                $destinationPath = public_path($uploadDir);
            } else {
                // for cpanel linux
                $destinationPath = dirname(base_path()) . $uploadDir;
            }
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath);
            }
            $img_name = "product_image-" . uniqid() . "." . $extension;
            // $img = Image::make($image->getRealPath());
            // $img->resize(768, 432)->save($destinationPath."/". $img_name);
            // another approach if Image class not functioning
            $request->product_image->move($destinationPath, $img_name);
            $requests["product_image"] = $uploadDir . $img_name;
        }



        Product::find($id)->update($requests);

        return response()->json(['status' => 'success', 'message' => 'Product Updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully!'
        ]);
    }
}
