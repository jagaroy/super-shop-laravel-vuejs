<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController;

use App\Http\Controllers\Api\CommonController;

use App\Http\Controllers\Api\Frontend\WebUserController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;

use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
});

// authentication is checked inside middleware
Route::group(['middleware'=>'permission', 'as' => 'admin.', 'prefix' => 'admin'], function () {

    Route::resource('users', UserController::class);
    Route::get('dashboard', [UserController::class, 'dashboard']);

    Route::resource('roles', RoleController::class);
    Route::get('role-list', [RoleController::class, 'role_list']);

    Route::resource('permissions', PermissionController::class);
    Route::post('permission-list', [PermissionController::class, 'getPermissionList']);

    Route::get('my_profile', [UserController::class, 'my_profile']);

	Route::put('my_profile_update', [UserController::class, 'my_profile_update']);

    Route::resource('suppliers', SupplierController::class);
    Route::post('supplier_update/{id}', [SupplierController::class, 'update']);

    Route::resource('brands', BrandController::class);
    Route::post('brand_update/{id}', [BrandController::class, 'update']);

    Route::resource('categories', CategoryController::class);
    Route::post('category_update/{id}', [CategoryController::class, 'update']);

    Route::resource('sub_categories', SubCategoryController::class);
    Route::post('sub_category_update/{id}', [SubCategoryController::class, 'update']);

    Route::resource('products', ProductController::class);
    Route::post('product_update/{id}', [ProductController::class, 'update']);

    Route::resource('stocks', StockController::class);
    Route::post('stock_update/{id}', [StockController::class, 'update']);

    Route::get('category-list', [CommonController::class, 'category_list']);
    Route::get('sub-category-list', [CommonController::class, 'sub_category_list']);
    Route::get('supplier-list', [CommonController::class, 'supplier_list']);
    Route::get('brand-list', [CommonController::class, 'brand_list']);
    Route::get('product-list', [CommonController::class, 'product_list']);
    Route::get('get_random_number', [CommonController::class, 'get_random_number']);

});

// authentication is checked inside middleware
Route::group(['middleware'=>'web_permission', 'as' => 'netuser.', 'prefix' => 'netuser'], function () {

    Route::get('netusers', [WebUserController::class, 'index'])->name('webuser.index');

});
