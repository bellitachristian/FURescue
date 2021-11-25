<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adopter_id')->nullable();
            $table->foreign('adopter_id')->references('id')->on('adopter')->onUpdate('cascade')->onDelete('cascade');  
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade');  
            $table->unsignedBigInteger('usertype_id')->nullable();
            $table->foreign('usertype_id')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');  
            $table->string('owner_id')->nullable();
            $table->unsignedBigInteger('adoption_id')->nullable();
            $table->foreign('adoption_id')->references('id')->on('adoption')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('adoption_payment')->onUpdate('cascade')->onDelete('cascade'); 
            $table->string('status'); 
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
        Schema::dropIfExists('receipt');
    }
}
