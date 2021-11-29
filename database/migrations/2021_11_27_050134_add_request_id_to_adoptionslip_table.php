<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestIdToAdoptionslipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adoptionslip', function (Blueprint $table) {
            $table->unsignedBigInteger('reqadoption_id')->nullable();
            $table->foreign('reqadoption_id')->references('id')->on('request')->onUpdate('cascade')->onDelete('cascade');      
            $table->string('status');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adoptionslip', function (Blueprint $table) {
            //
        });
    }
}
