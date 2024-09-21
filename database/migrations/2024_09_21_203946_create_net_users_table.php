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
        Schema::create('net_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('net_user_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->enum('net_user_status', ['Active', 'Expired', 'Left'])->comment('Active, Expired, Left');
            $table->unsignedBigInteger('package_id');
            $table->string('net_user_ip')->nullable();
            $table->date('net_user_expiration')->nullable();
            $table->integer('last_extend_days')->nullable();
            $table->string('net_user_phone');
            $table->text('net_user_address');
            $table->double('net_user_price', 8, 2);
            $table->date('net_user_registered');
            $table->unsignedBigInteger('router_id')->index('net_users_router_id_foreign');
            $table->enum('user_type', ['Queue', 'Pppoe']);
            $table->unsignedBigInteger('queue_id')->nullable();
            $table->unsignedBigInteger('pppoe_id')->nullable();
            $table->enum('net_user_connection_type', ['ONU', 'UTP', 'MC'])->nullable()->comment('ONU, UTP, MC');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('authored_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('net_users');
    }
};
