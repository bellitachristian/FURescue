<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocatevaccineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocatevaccine', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vac_id')->nullable();
            $table->foreign('vac_id')->references('id')->on('vaccine')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade'); 
            $table->date('vac_date')->nullable();
            $table->date('vac_expiry_date')->nullable();
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
        Schema::dropIfExists('allocatevaccine');
    }
}
