<?php

use Illuminate\Database\Seeder;
use App\Group;
use Faker\Factory as Faker;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 20; $i++){
            $user_id = $faker->numberBetween(1,20);
            $user_id = $user_id >= 15 ? 1 : $user_id;

            $group = new Group([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'created_by' => $user_id
            ]);

            $group->save();
        }
    }
}
