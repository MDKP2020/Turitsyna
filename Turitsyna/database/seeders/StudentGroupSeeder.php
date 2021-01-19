<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id'=> 1, 'date' => '01.09.2020', 'student_id' => 1,
            'group_id' => 1, 'status_id' => 1],
            ['id'=> 2, 'date' => '01.09.2020', 'student_id' => 2,
                'group_id' => 2, 'status_id' => 1],
            ['id'=> 3, 'date' => '01.09.2020', 'student_id' => 3,
                'group_id' => 3, 'status_id' => 1],
            ['id'=> 4, 'date' => '01.09.2020', 'student_id' => 4,
                'group_id' => 4, 'status_id' => 1],];

        foreach ($arr as &$element) {
            DB::table('student_group')->insert($element);
        }
    }
}