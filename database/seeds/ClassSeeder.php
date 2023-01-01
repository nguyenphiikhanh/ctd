<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('classes')->updateOrInsert(
            ['id' => 1],
            [
                'class_name' => 'K69C',
                'id_faculty' => 2,
                'id_class_type' => 2,
                'id_term' => 1,
            ]
        );

        DB::table('classes')->updateOrInsert(
            ['id' => 2],
            [
                'class_name' => 'K69A',
                'id_faculty' => 2,
                'id_class_type' => 1,
                'id_term' => 1,
            ]
        );
    }
}
