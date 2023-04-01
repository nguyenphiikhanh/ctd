<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateLastScoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $this->line('Generating last score...');
            DB::connection('mysql')->transaction(function () {
                $before = DB::table('study_times')->latest('id')->skip(1)->first(); // tổng hợp điểm nckh + Đoàn
                $current = DB::table('study_times')->latest('id')->first();
                $dataCollections = DB::table('personal_score')
                    ->where('id_study_time', $current->id)
                    ->select(DB::raw('SUM(score) as sum_score'), 'id_user')
                    ->groupBy('id_study_time','id_user')
                    ->get();
                $dataInserts = [];
                foreach($dataCollections as $userLastScore){
                    $dataInserts[] = [
                        'id_study_time' => $current->id,
                        'sum_score' => $userLastScore->sum_score,
                        'id_user' => $userLastScore->id_user,
                    ];
                }
                DB::table('last_score')->insert($dataInserts);
            });
            $this->info('Generated last score successfully!');
            return 0;
        }
        catch(\Exception $e){
            Log::error("Error Command person score!");
            Log::error($e->getMessage(). $e->getTraceAsString());
        }
    }
}
