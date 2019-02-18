<?php

use Illuminate\Database\Seeder;
use App\News;
use Faker\Factory as Faker;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 12; $i++) { 
            $content = '';
            for ($j = 0; $j < 8; $j++){
                $content .= '<p>'. $faker->paragraph . '</p>';
            }
            
            $news = new News([
                'title' => $faker->sentence,
                'content' => $content,
                'visible' => true,
                'created_by' => 1,
            ]);

            $news->save();
        }
    }
}
