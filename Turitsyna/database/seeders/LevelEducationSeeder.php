<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelEducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id'=> 1, 'name' => 'Бакалавриат', 'period_of_study' => 4],
            ['id'=> 2, 'name' => 'Магистратура', 'period_of_study' => 2]];

        foreach ($arr as &$element) {
            DB::table('level_education')->insert($element);
        }
    }
}
