<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id'=> 1, 'name' => 'Иван', 'surname' => 'Иванов', 'patronomyc' => 'Иванович'],
            ['id'=> 2, 'name' => 'Петр', 'surname' => 'Петров', 'patronomyc' => 'Петрович'],
            ['id'=> 3, 'name' => 'Дмитрий', 'surname' => 'Дмитриев', 'patronomyc' => 'Дмитриевич'],
            ['id'=> 4, 'name' => 'Артем', 'surname' => 'Артемов', 'patronomyc' => 'Артемович'],
            ['id'=> 5, 'name' => 'Александра', 'surname' => 'Александрова', 'patronomyc' => 'Александровна'],
            ['id'=> 6, 'name' => 'Евгения', 'surname' => 'Евгеньева', 'patronomyc' => 'Евгеньевна'],
            ['id'=> 7, 'name' => 'Марина', 'surname' => 'Дмитриева', 'patronomyc' => 'Александровна'],
            ['id'=> 8, 'name' => 'Мария', 'surname' => 'Артемова', 'patronomyc' => 'Артемовна']];

        foreach ($arr as &$element) {
            DB::table('student')->insert($element);
        }
    }
}
