<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDewormhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dewormhistory', function (Blueprint $table) {
            $table->id();
            $table->string('dew_name');
            $table->string('dew_desc');
            $table->string('dew_date');
            $table->string('dew_expiry');
            $table->string('stats');
            $table->unsignedBigInteger('petbook_id')->nullable();
            $table->foreign('petbook_id')->references('id')->on('petbook')->onUpdate('cascade')->onDelete('cascade');       
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade');       
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
        Schema::dropIfExists('dewormhistory');
    }
}
