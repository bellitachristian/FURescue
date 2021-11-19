<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocatedewormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocatedeworm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dew_id')->nullable();
            $table->foreign('dew_id')->references('id')->on('deworm')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade'); 
            $table->date('dew_date')->nullable();
            $table->date('dew_expiry_date')->nullable();
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
        Schema::dropIfExists('allocatedeworm');
    }
}
