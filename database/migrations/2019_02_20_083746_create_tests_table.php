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
            
            $table->integer('group_id');
            $table->integer('teacher_id');
            
            $table->timestamp('available_from')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->timestamp('available_to')->default(DB::raw('CURRENT_TIMESTAMP'));;
            $table->boolean('available_description');
            $table->boolean('mix_questions');
            $table->boolean('available_answers');

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
        Schema::dropIfExists('tests');
    }
}
