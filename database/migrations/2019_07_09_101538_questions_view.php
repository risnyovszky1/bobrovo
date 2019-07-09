<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class QuestionsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("
            CREATE VIEW questions_view
            AS
            SELECT DISTINCT
                questions.id, TRIM(questions.title) as title, questions.type, questions.difficulty, questions.created_by,
                COALESCE(avg(ratings.rating), 0) as rating,
                COALESCE(count(ratings.rating), 0) as rating_count,
                (SELECT count(comments.id) FROM comments WHERE comments.question_id = questions.id) as comments,
                (SELECT count(question_test.test_id) FROM question_test WHERE question_test.question_id = questions.id) as popularity 
            FROM
                questions
                LEFT OUTER JOIN ratings ON questions.id = ratings.question_id
            GROUP BY questions.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("DROP VIEW questions_view");
    }
}
