<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption_fee', function (Blueprint $table) {
            $table->id();
            $table->string('type'); 
            $table->string('cat_fee')->nullable();
            $table->string('dog_fee')->nullable();
            $table->unsignedBigInteger('categ_id')->nullable();
            $table->foreign('categ_id')->references('id')->on('category')->onUpdate('cascade')->onDelete('cascade'); 
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
        Schema::dropIfExists('adoption_fee');
    }
}
