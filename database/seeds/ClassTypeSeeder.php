<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('class_type')->updateOrInsert(
            ['id' => 1],
            ['type_name' => 'Khối Sư phạm']
        );

        DB::table('class_type')->updateOrInsert(
            ['id' => 2],
            ['type_name' => 'Khối Cử nhân']
        );
    }
}
