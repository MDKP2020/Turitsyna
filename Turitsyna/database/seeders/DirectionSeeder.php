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
        $arr = [['id'=> 1, 'name' => 'PRIN'], ['id'=> 2, 'name' => 'IVT'],
            ['id'=> 3, 'name' => 'IIT'], ['id'=> 4, 'name' => 'FIZ'],];

        foreach ($arr as &$element) {
            DB::table('direction')->insert($element);
        }
    }
}
