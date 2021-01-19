<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id'=> 1, 'start_year' => 2017],
            ['id'=> 2, 'start_year' => 2018],
            ['id'=> 3, 'start_year' => 2019],
            ['id'=> 4, 'start_year' => 2020]];

        foreach ($arr as &$element) {
            DB::table('study_year')->insert($element);
        }
    }
}
