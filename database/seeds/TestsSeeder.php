<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Test;

class TestsSeeder extends Seeder
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

        for($i = 0; $i < 30; $i++){
            $uid = DB::table('users')->select('id')->inRandomOrder()->first()->id;
            $g = DB::table('groups')->select('id')->where('created_by', $uid)->inRandomOrder()->first();
            if ($g){
                $test = new Test([
                    'name' => $faker->sentence,
                    'description' => '<p>' . $faker->paragraph . '</p>',
                    'teacher_id' => $uid,
                    'group_id' => $g->id,
                    'available_from' => '2019-04-01 08:00:00',
                    'available_to' => '2019-04-15 08:00:00',
                    'available_description' => $faker->boolean,
                    'available_answers' => $faker->boolean,
                    'mix_questions' => $faker->boolean,
                    'public' => true
                ]);
                $test->save();
            }
            
        }
    }
}
