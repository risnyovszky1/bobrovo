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

        for($i = 0; $i < 15; $i++){
            $question = new Question([
                'title' => $faker->sentence,
                'question' => '<p>' . $faker->paragraph . '</p>',
                'a' => $faker->word,
                'b' => $faker->word,
                'c' => $faker->word,
                'd' => $faker->word,
                'answer' => $arr[$faker->numberBetween(0, 3)],
                'type' => $faker->numberBetween(1, 3),
                'difficulty' => $faker->numberBetween(1, 7),
                'description' => '<p>' . $faker->paragraph . '</p>',
                'description_teacher' => '<p>' . $faker->paragraph . '</p>',
                'created_by' => 1,
                'public' => true
            ]);

            $question->save();
        }

        $file = File::get('database/data/questions.json');
        $json = json_decode($file);
        foreach($json as $data){
            $q = new Question([
                'title' => $data->title,
                'question' => $data->otazka,
                'a' => $data->a,
                'b' => $data->b,
                'c' => $data->c,
                'd' => $data->d,
                'answer' => $data->ans,
                'type' => empty($data->type) ? $faker->numberBetween(1, 3) : $data->type,
                'difficulty' => $faker->numberBetween(1, 7),
                'description' => $data->desc,
                'description_teacher' => $data->desc_teache,
                'created_by' => 1,
                'public' => true
            ]);

            $q->save();
        }
    }
}
