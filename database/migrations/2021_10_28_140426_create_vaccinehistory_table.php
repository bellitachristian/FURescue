<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinehistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinehistory', function (Blueprint $table) {
            $table->id();
            $table->string('vac_name');
            $table->string('vac_desc');
            $table->string('vac_date');
            $table->string('vac_expiry');
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
        Schema::dropIfExists('vaccinehistory');
    }
}
