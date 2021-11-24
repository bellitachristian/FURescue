<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('sender')->nullable();
            $table->foreign('sender')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');
            $table->string('owner_id')->nullable();
            $table->unsignedBigInteger('owner_type')->nullable();
            $table->foreign('owner_type')->references('id')->on('usertype')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('sub_id')->nullable();
            $table->foreign('sub_id')->references('id')->on('subscription')->onUpdate('cascade')->onDelete('cascade');      
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
        Schema::dropIfExists('feedback');
    }
}
