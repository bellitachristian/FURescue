<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidDocuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valid_docu', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('extension');
            $table->unsignedBigInteger('shelter_id')->nullable();
            $table->foreign('shelter_id')->references('id')->on('animal_shelters')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('petowner_id')->nullable();
            $table->foreign('petowner_id')->references('id')->on('pet_owners')->onUpdate('cascade')->onDelete('cascade');    
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
        Schema::dropIfExists('valid_docu');
    }
}
