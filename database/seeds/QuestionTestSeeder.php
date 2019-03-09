<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuestionTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for($i = 0; $i < 300; $i++){
            $qid = $faker->numberBetween(1, 60);
            $tid = $faker->numberBetween(1, 60);

            $count = DB::table('question_test')->where([
                ['question_id', $qid],
                ['test_id', $tid]
            ])->count();

            if ($count == 0){
                DB::table('question_test')->insert([
                    'question_id' => $qid,
                    'test_id' => $tid
                ]);
            }
        }
    }
}
