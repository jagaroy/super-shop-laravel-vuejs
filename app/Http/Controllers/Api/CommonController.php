<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{

    public function category_list(Request $request)
    {
        $categories = Category::latest('id')->get();
        $response = [
            'status' => 'success',
            'data' => $categories,
            'message' => 'All Categories'
        ];
        return response()->json($response, 200);
    }

    public function sub_category_list(Request $request)
    {
        $sub_categories = SubCategory::latest('id')->get();
        $response = [
            'status' => 'success',
            'data' => $sub_categories,
            'message' => 'All Sub Categories'
        ];
        return response()->json($response, 200);
    }

    public function supplier_list(Request $request)
    {
        $suppliers = Supplier::latest('id')->get();
        $response = [
            'status' => 'success',
            'data' => $suppliers,
            'message' => 'All suppliers'
        ];
        return response()->json($response, 200);
    }
    public function brand_list(Request $request)
    {
        $brands = Brand::latest('id')->get();
        $response = [
            'status' => 'success',
            'data' => $brands,
            'message' => 'All brands'
        ];
        return response()->json($response, 200);
    }

    public function get_random_number(Request $request)
    {
        $skus = \App\Models\Product::select("id", "sku")->get()->pluck('sku')->toArray();

        $random_number = 0;
        // we will get a random number with in a very few loops
        for ($i=1; $i <= 10000; $i++) {
            $random_number = rand(10, 10000);
            if( ! in_array($random_number, $skus)){
                break;
            }
        }

        $response = [
            'status' => 'success',
            'data' => $random_number,
            'message' => 'random_number'
        ];
        return response()->json($response, 200);
    }

    public function product_list(Request $request)
    {
        $products = Product::latest('id')->get();
        $response = [
            'status' => 'success',
            'data' => $products,
            'message' => 'All products'
        ];
        return response()->json($response, 200);
    }


}
