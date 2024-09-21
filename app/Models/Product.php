<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    // protected $fillable = ["id","name","supplier_id","brand_id","category_id","sub_category_id","product_image","unit_type","purchase_price_per_unit","retail_price_per_unit","sku","remarks","authored_by"];
    protected $guarded = [];


	public function supplier()
	{
		return $this->belongsTo(\App\Models\Supplier::class, "supplier_id");
	}
	public function brand()
	{
		return $this->belongsTo(\App\Models\Brand::class, "brand_id");
	}
	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class, "category_id");
	}
	public function sub_category()
	{
		return $this->belongsTo(\App\Models\SubCategory::class, "sub_category_id");
	}

}
