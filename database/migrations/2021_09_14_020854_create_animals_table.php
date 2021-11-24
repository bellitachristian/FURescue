<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('animal_image');
            $table->string('name');
            $table->string('category');
            $table->string('age');
            $table->string('gender');
            $table->string('size');
            $table->string('breed');
            $table->string('history');
            $table->string('color');
            $table->string('info');
            $table->string('pet_stage')->nullable();
            $table->string('status');
            $table->string('fee')->nullable();
            $table->string('post_status')->default('not posted');
            $table->string('petbooked')->nullable();
            $table->unsignedBigInteger('petowner_id')->nullable();
            $table->foreign('petowner_id')->references('id')->on('pet_owners')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('shelter_id')->nullable();
            $table->foreign('shelter_id')->references('id')->on('animal_shelters')->onUpdate('cascade')->onDelete('cascade'); 
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
        Schema::dropIfExists('animals');
    }
}
