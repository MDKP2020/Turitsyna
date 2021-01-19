<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [['id'=> 1, 'name' => 'Enrolled'], ['id'=> 2, 'name' => 'Expelled']];

        foreach ($arr as &$element) {
            DB::table('status')->insert($element);
        }
    }
}
