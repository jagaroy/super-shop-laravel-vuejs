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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['user', 'superadmin'])->default('user')->comment('user,superadmin');
            $table->unsignedInteger('role_id')->nullable();
            $table->string('name')->unique('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone', 191)->unique('phone');
            $table->string('image')->nullable();
            $table->enum('status', ['Inactive', 'Active'])->default('Inactive')->comment('Inactive, Active');
            $table->integer('authored_by');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
