<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 1; $i <= 4; $i++){
            DB::table('terms')->updateOrInsert(
                ['id' => $i],
                ['term_name' => 'K'.($i + 68)]
            );
        }
    }
}
