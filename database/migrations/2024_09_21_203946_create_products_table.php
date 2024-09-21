<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->unique('name');
            $table->string('supplier_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('sub_category_id');
            $table->string('product_image')->nullable();
            $table->enum('unit_type', ['Kg', 'Piece'])->comment('Kg,Piece');
            $table->float('purchase_price_per_unit', 10, 0)->nullable();
            $table->float('retail_price_per_unit', 10, 0);
            $table->string('sku');
            $table->string('remarks')->nullable();
            $table->integer('authored_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
