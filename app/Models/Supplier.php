<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'suppliers';

    // protected $fillable = ["id","supplier_name","company_name","phone","email","address","website","remarks","authored_by"];
    protected $guarded = [];
}
