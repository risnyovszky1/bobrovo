<?php

use Illuminate\Database\Seeder;
use App\Question;
use Faker\Factory as Faker;

class QuestionSeeder extends Seeder
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
        $arr = array('a', 'b', 'c', 'd');

        for($i = 0; $i < 70; $i++){
            $question = new Question([
                'title' => $faker->sentence,
                'question' => '<p>' . $faker->paragraph . '</p>',
                'a' => $faker->word,
                'b' => $faker->word,
                'c' => $faker->word,
                'd' => $faker->word,
                'answer' => $arr[array_rand($arr)],
                'type' => $faker->numberBetween(1, 3),
                'difficulty' => $faker->numberBetween(1, 7),
                'description' => '<p>' . $faker->paragraph . '</p>',
                'description_teacher' => '<p>' . $faker->paragraph . '</p>',
                'created_by' => 1,
                'public' => true
            ]);

            $question->save();
        }
    }
}
