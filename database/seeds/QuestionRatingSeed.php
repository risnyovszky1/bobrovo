<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuestionRatingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 500; $i++){
            $uid = $faker->numberBetween(1, 16);
            $qid = $faker->numberBetween(1, 70);

            $count = DB::table('ratings')->where([
                ['user_id', $uid],
                ['question_id', $qid]
            ])->count();

            if($count == 0){
                DB::table('ratings')->insert([
                    'question_id' => $qid,
                    'user_id' => $uid,
                    'rating' => $faker->numberBetween(1, 5)
                ]);
            }
        }
    }
}
