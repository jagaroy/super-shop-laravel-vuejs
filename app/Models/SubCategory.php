<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $table = 'sub_categories';

    // protected $fillable = ["id","category_id","name","remarks","authored_by"];
    protected $guarded = [];


	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class, "category_id");
	}

}
