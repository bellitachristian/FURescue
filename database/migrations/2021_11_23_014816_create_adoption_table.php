<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('animal_id');
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('adopter_id');
            $table->foreign('adopter_id')->references('id')->on('adopter')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('owner_id')->nullable();
            $table->unsignedBigInteger('owner_type');
            $table->foreign('owner_type')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->string('feedback')->nullable();
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
        Schema::dropIfExists('adoption');
    }
}
