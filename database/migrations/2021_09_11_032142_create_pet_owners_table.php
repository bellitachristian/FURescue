<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_owners', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('gcash');
            $table->string('pay_pal');
            $table->string('contact');
            $table->string('gender');
            $table->string('address');
            $table->string('email');
            $table->string('password');
            $table->string('profile')->default('default.png');
            $table->unsignedBigInteger('usertype_id');
            $table->foreign('usertype_id')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');
            $table->string('account_status')->nullable();
            $table->string('verfication_code')->nullable();
            $table->string('is_verified_account')->default('0');
            $table->string('is_verified_activation')->default('0');
            $table->string('is_verified_petowner')->default('0');
            $table->string('is_welcome_petowner')->default('0');
            $table->string('deact_reason')->nullable();
 
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
        Schema::dropIfExists('pet_owners');
    }
}
