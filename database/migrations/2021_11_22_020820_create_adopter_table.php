<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdopterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopter', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
            $table->string('phonenum');
            $table->string('gender');
            $table->string('birthdate');
            $table->string('address');
            $table->string('password');
            $table->string('photo');
            $table->string('status');
            $table->string('verification_code');
            $table->string('email_verified_at');
            $table->string('reason');
            $table->string('reactivation_request');
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
        Schema::dropIfExists('adopter');
    }
}
