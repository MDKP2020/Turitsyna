<?php

namespace Database\Seeders;

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
        $this->call(DirectionSeeder::class);
        $this->call(StudyYearSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(LevelEducationSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(StudentGroupSeeder::class);
    }
}
