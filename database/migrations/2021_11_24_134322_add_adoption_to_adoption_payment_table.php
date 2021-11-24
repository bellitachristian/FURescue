<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdoptionToAdoptionPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adoption_payment', function (Blueprint $table) {
            $table->unsignedBigInteger('adoption_id')->nullable();
            $table->foreign('adoption_id')->references('id')->on('adoption')->onUpdate('cascade')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adoption_payment', function (Blueprint $table) {
            //
        });
    }
}
