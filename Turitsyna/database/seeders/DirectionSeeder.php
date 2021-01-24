<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id'=> 1, 'name' => 'ПрИн'], ['id'=> 2, 'name' => 'ИВТ'],
            ['id'=> 3, 'name' => 'ИИТ'], ['id'=> 4, 'name' => 'Ф'],];

        foreach ($arr as &$element) {
            DB::table('direction')->insert($element);
        }
    }
}
