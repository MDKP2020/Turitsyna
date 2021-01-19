<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id' => 1, 'name'=> '66', 'lvl_education_id' => 1,
            'study_year_id' => 4, 'course' => 1, 'direction_id' => 1],
            ['id' => 2, 'name'=> '66', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 2, 'direction_id' => 1],
            ['id' => 3, 'name'=> '66', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 3, 'direction_id' => 1],
            ['id' => 4, 'name'=> '66', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 4, 'direction_id' => 1]];

        foreach ($arr as &$element) {
            DB::table('group')->insert($element);
        }
    }
}