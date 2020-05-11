<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'email' => 'risnyo96@gmail.com',
            'first_name' => 'András',
            'last_name' => 'Risnyovszký',
            'password' => bcrypt('asdasd'),
            'is_admin' => true,
        ]);
        $user->save();

        $faker = Faker::create();
        for($i = 0; $i < 3; $i++){
            $user = new User([
                'email' => $faker->email,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'password' => bcrypt('testovanie'),
                'is_admin' => false,
            ]);

            $user->save();
        }
    }
}
