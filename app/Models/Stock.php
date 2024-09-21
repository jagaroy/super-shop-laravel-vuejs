<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $table = 'stocks';

    // protected $fillable = ["id","product_id","quantity","remarks","authored_by"];
    protected $guarded = [];


	public function product()
	{
		return $this->belongsTo(\App\Models\Product::class, "product_id");
	}

}
