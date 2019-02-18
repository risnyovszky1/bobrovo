<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 230; $i++){
            $student = DB::table('students')->select('id', 'teacher_id')->inRandomOrder()->first();
            $group = DB::table('groups')->select('id')->where('created_by', $student->teacher_id)->inRandomOrder()->first();

            if ($student && $group){
                $count = DB::table('student_group')->where([
                        ['student_id', $student->id],
                        ['group_id', $group->id] 
                    ])->count();
                if ($count == 0){
                    DB::table('student_group')->insert([
                        'student_id' => $student->id,
                        'group_id' => $group->id
                      ]);
                }
            }       
        }
    }
}
