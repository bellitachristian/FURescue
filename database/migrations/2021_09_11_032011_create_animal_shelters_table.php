<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalSheltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_shelters', function (Blueprint $table) {
            $table->id();
            $table->string('shelter_name');
            $table->string('g_cash');
            $table->string('email');
            $table->string('pay_pal');
            $table->string('password');
            $table->string('address');
            $table->string('founder_name');
            $table->string('contact');
            $table->string('profile')->default('default.png');
            $table->unsignedBigInteger('usertype_id');
            $table->foreign('usertype_id')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');
            $table->string('account_status')->nullable();
            $table->string('verfication_code')->nullable();
            $table->string('is_verified_account')->default('0');
            $table->string('is_verified_activation')->default('0');
            $table->string('is_verified_shelter')->default('0');
            $table->string('is_welcome_shelter')->default('0');
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
        Schema::dropIfExists('animal_shelters');
    }
}
