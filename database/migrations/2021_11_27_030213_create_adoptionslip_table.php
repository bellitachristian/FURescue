<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionslipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoptionslip', function (Blueprint $table) {
            $table->id();
            $table->text('slip_number');
            $table->string('date_approve');
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('shelter_id')->nullable();
            $table->foreign('shelter_id')->references('id')->on('animal_shelters')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedBigInteger('petowner_id')->nullable();
            $table->foreign('petowner_id')->references('id')->on('pet_owners')->onUpdate('cascade')->onDelete('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *s
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoptionslip');
    }
}
