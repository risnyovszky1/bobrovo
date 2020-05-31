<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('description');

            $table->integer('group_id')->unsigned();
            $table->integer('teacher_id')->unsigned();

            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_to')->nullable();
            $table->integer('time_to_do')->nullable();
            $table->boolean('available_description')->nullable();
            $table->boolean('mix_questions');
            $table->boolean('available_answers');
            $table->boolean('public');

            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
