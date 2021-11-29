<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adoption_id')->nullable();
            $table->foreign('adoption_id')->references('id')->on('adoption')->onUpdate('cascade')->onDelete('cascade');   
            $table->text('question1')->nullable(); 
            $table->text('question2')->nullable();
            $table->text('question3')->nullable();
            $table->text('question4')->nullable(); 
            $table->text('question5')->nullable();
            $table->text('question6')->nullable(); 
            $table->text('question7')->nullable(); 
            $table->text('question8')->nullable(); 
            $table->text('question9')->nullable(); 
            $table->text('question10')->nullable(); 
            $table->text('question11')->nullable(); 
            $table->text('question12')->nullable(); 
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
        Schema::dropIfExists('questionnaire');
    }
}
