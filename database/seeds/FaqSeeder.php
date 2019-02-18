<?php

use Illuminate\Database\Seeder;
use App\Faq;
use Faker\Factory as Faker;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 9; $i++) { 
            $faq = new Faq([
                'question' => $faker->sentence,
                'answer' => $faker->paragraph,
            ]); 

            $faq->save();
        }
    }
}
