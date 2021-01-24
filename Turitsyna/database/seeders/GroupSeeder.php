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
        $arr = [['id' => 1, 'name'=> 'ПРИН-166', 'lvl_education_id' => 1,
            'study_year_id' => 4, 'course' => 1, 'direction_id' => 1],
            ['id' => 2, 'name'=> 'ПРИН-266', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 2, 'direction_id' => 1],
            ['id' => 3, 'name'=> 'ПРИН-366', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 3, 'direction_id' => 1],
            ['id' => 4, 'name'=> 'ПРИН-466', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 4, 'direction_id' => 1],
            ['id' => 5, 'name'=> 'ИВТ-163', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 1, 'direction_id' => 2],
            ['id' => 6, 'name'=> 'ИВТ-263', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 2, 'direction_id' => 2],
            ['id' => 7, 'name'=> 'ИВТ-363', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 3, 'direction_id' => 2],
            ['id' => 8, 'name'=> 'ИВТ-463', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 4, 'direction_id' => 2],
            ['id' => 9, 'name'=> 'ИИТ-173', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 1, 'direction_id' => 3],
            ['id' => 10, 'name'=> 'ИИТ-373', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 3, 'direction_id' => 3],
            ['id' => 11, 'name'=> 'Ф-169', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 1, 'direction_id' => 4],
            ['id' => 12, 'name'=> 'Ф-269', 'lvl_education_id' => 1,
                'study_year_id' => 4, 'course' => 2, 'direction_id' => 4]];

        foreach ($arr as &$element) {
            DB::table('group')->insert($element);
        }
    }
}
