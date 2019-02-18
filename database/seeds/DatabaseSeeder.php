<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            FaqSeeder::class,
            MsgSeeder::class,
            NewsSeeder::class,
            GroupsSeeder::class,
            StudentSeeder::class,
            StudentGroupSeeder::class,
        ]);
    }
}
