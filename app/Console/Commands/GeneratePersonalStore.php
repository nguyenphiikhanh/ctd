<?php

namespace App\Console\Commands;

use App\Http\Utils\RoleUtils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneratePersonalStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'score:personal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate personal score';

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
            $current = DB::table('study_times')->latest('id')->first();
            $students = DB::table('users')->where('role', RoleUtils::ROLE_CBL)
                    ->orWhere('role', RoleUtils::ROLE_SINHVIEN)
                    ->orWhere('role', RoleUtils::ROLE_LOP_TRUONG)
                    ->get();
            $listTieuchi = DB::table('tieu_chi')->get();
            Log::debug("Personal score generation command.");
            $this->line('Personal score generating...');
            DB::connection('mysql')->beginTransaction();
            foreach($students as $student){
                foreach($listTieuchi as $tieu_chi){
                    DB::table('personal_score')->updateOrInsert(
                        ['id_user' => $student->id, 'id_study_time' => $current->id, 'id_tieu_chi' => $tieu_chi->id],
                        [
                            'max_score' =>$tieu_chi->max_score,
                        ]
                    );
                }
            }
            Log::debug('Success personal score generation!');
            $this->info('Success personal score generation!');
            DB::commit();
        }
        catch(\Exception $e){
            $this->error("Error Command person score!");
            DB::rollBack();
            Log::error("Error Command person score!");
            Log::error($e->getMessage(). $e->getTraceAsString());
        }
    }
}
