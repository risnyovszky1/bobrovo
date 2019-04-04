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

        for($i = 0; $i < 15; $i++){
            $group = new Group([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'created_by' => $faker->numberBetween(1,4)
            ]);

            $group->save();
        }
    }
}
