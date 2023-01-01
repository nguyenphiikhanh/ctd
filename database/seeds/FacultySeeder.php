<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('faculties')->updateOrInsert(
            ['id' => 1],
            ['faculty_name' => 'Tâm lý học']
        );

        DB::table('faculties')->updateOrInsert(
            ['id' => 2],
            ['faculty_name' => 'Công nghệ thông tin']
        );
    }
}
