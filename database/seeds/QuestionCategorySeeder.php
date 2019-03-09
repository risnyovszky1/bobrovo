<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        
        for($i = 0; $i < 100; $i++){
            $qid = $faker->numberBetween(1, 70);
            $cid = $faker->numberBetween(1, 17);

            $count = DB::table('question_category')->where([
                ['question_id', $qid],
                ['category_id', $cid]
            ])->count();

            if ($count == 0){
                DB::table('question_category')->insert([
                    'question_id' => $qid,
                    'category_id' => $cid
                ]);
            }
        }
    }
}
