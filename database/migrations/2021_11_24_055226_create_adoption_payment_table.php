<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('adopter_id')->nullable();
            $table->foreign('adopter_id')->references('id')->on('adopter')->onUpdate('cascade')->onDelete('cascade');
            $table->string('owner_id')->nullable();
            $table->unsignedBigInteger('owner_type')->nullable();
            $table->foreign('owner_type')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');
            $table->string('paymentMethod')->nullable();
            $table->string('fee')->nullable();
            $table->string('message')->nullable();
            $table->string('proof')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('adoption_payment');
    }
}
