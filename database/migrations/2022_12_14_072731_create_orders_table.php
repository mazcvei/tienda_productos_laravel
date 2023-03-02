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
        Schema::create('orders', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('transaction',256)->nullable();
            $table->decimal('total',$precision = 8, $scale = 2)->nullable($value = false);
            $table->tinyInteger('pay')->nullable($value = false)->default(0);
            $table->unsignedBigInteger('paypal')->nullable($value = false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->engine ='innoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
