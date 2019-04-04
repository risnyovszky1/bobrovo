<?php

use Illuminate\Database\Seeder;
use App\Message;
use Faker\Factory as Faker;

class MsgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 10; $i++) { 

            $msg = new Message([
                'from' => $faker->numberBetween(1, 4),
                'to' => $faker->numberBetween(1, 4),
                'subject' => $faker->sentence,
                'content' => $faker->paragraph,
            ]); 
            
            $msg->save();
        }
    }
}
