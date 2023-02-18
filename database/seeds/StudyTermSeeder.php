<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('study_terms')->updateOrInsert(
            ['id' => 1],
            ['name' => 'Học kì I']
        );
        DB::table('study_terms')->updateOrInsert(
            ['id' => 2],
            ['name' => 'Học kì II']
        );
        DB::table('study_terms')->updateOrInsert(
            ['id' => 3],
            ['name' => 'Học kì III']
        );
    }
}
