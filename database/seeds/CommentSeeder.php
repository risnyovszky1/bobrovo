<?php

use Illuminate\Database\Seeder;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
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

        for($i = 0; $i < 38; $i++){
            $comment = new Comment([
                'user_id' => DB::table('users')->select('id')->inRandomOrder()->first()->id,
                'question_id' => DB::table('questions')->select('id')->inRandomOrder()->first()->id,
                'comment' => $faker->paragraph
            ]);

            $comment->save();
        }
    }
}
