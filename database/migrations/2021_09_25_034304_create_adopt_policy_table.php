<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptPolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopt_policy', function (Blueprint $table) {
            $table->id();
            $table->string('policy_content');
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
        Schema::dropIfExists('adopt_policy');
    }
}
