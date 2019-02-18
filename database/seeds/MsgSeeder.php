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
        
        for ($i = 0; $i < 30; $i++) { 
            $to = $faker->numberBetween(1,23);
            if ($to >= 15)
                $to = 1;

            $msg = new Message([
                'from' => $faker->numberBetween(1,15),
                'to' => $to,
                'subject' => $faker->sentence,
                'content' => $faker->paragraph,
            ]); 
            
            $msg->save();
        }
    }
}
