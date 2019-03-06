<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            
            $table->text('question');
            $table->string('a', 255);
            $table->string('b', 255);
            $table->string('c', 255);
            $table->string('d', 255);
            $table->string('answer', 10);
            
            $table->integer('type');
            $table->integer('difficulty');
            
            $table->text('description');
            $table->text('description_teacher');
            
            $table->integer('created_by')->unsigned();
            $table->boolean('public');
            
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
