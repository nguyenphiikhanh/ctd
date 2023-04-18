<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $dataPiorities = [];
        $dataPiorities[] = [
            'id_tieu_chi' => 8,
            'piority_level' => 1,
            'score' => 1.5,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 8,
            'piority_level' => 2,
            'score' => 1,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 8,
            'piority_level' => 3,
            'score' => 0.5,
        ];

        $dataPiorities[] = [
            'id_tieu_chi' => 13,
            'piority_level' => 1,
            'score' => 2.5,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 13,
            'piority_level' => 2,
            'score' => 1.5,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 13,
            'piority_level' => 3,
            'score' => 1,
        ];

        $dataPiorities[] = [
            'id_tieu_chi' => 18,
            'piority_level' => 1,
            'score' => -25,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 18,
            'piority_level' => 2,
            'score' => -15,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 18,
            'piority_level' => 3,
            'score' => -10,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 18,
            'piority_level' => 4,
            'score' => 0,
        ];

        $dataPiorities[] = [
            'id_tieu_chi' => 19,
            'piority_level' => 1,
            'score' => -25,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 19,
            'piority_level' => 2,
            'score' => -15,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 19,
            'piority_level' => 3,
            'score' => -10,
        ];
        $dataPiorities[] = [
            'id_tieu_chi' => 19,
            'piority_level' => 4,
            'score' => 0,
        ];
        DB::table('tc_piority')->insert($dataPiorities);
    }
}
