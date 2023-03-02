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
            $table->integerIncrements('id');
            $table->string('name',250)->nullable($value = false);
            $table->string('email',256)->nullable($value = false);
            $table->string('password',250)->nullable($value = false);
            $table->integer('credits')->default(0);
            $table->unsignedInteger('rol_id')->nullable($value = false);
            $table->timestamps();
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('restrict');
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
        Schema::dropIfExists('users');
    }
};
