<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 120; $i++){
            $uid = DB::table('users')->select('id')->inRandomOrder()->first();
            $student = new Student([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'teacher_id' => $uid->id,
                'code' => $faker->bothify('**********')
            ]);

            $student->save();
        }
    }
}
