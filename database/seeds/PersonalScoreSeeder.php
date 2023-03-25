<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $current = DB::table('study_times')->latest('id')->first();
    }
}
