<?php

namespace App\Console\Commands;

use App\Http\Utils\AppUtils;
use App\Http\Utils\TcUtils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LastScoreCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'score:collection';

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
            $this->line('Collect last score...');
            DB::connection('mysql')->transaction(function () {
                $before = DB::table('study_times')->latest('id')->skip(1)->first(); // tổng hợp điểm nckh + Đoàn
                $current = DB::table('study_times')->latest('id')->first();

                $act_nckh_ids = DB::table('child_activities')
                    ->join('activities_details', 'activities_details.id_child_activity', 'child_activities.id')
                    ->where('child_activities.id_activity', AppUtils::HOAT_DONG_NCKH)
                    ->where('child_activities.id_study_time', $before->id)
                    ->pluck('activities_details.id');
                $user_nckh = DB::table('user_activities')->whereIn('id_activities_details', $act_nckh_ids)
                    ->get();
                DB::table('personal_score') // update trạng thái hd NCKH
                    ->where('id_study_time', $current->id)
                    ->where('id_tieu_chi', TcUtils::TIEU_CHI_NCKH)
                    ->update([
                        'status' => AppUtils::SCORE_HOAN_THANH
                    ]);
                DB::table('personal_score') // update trạng thái NCkh có giải
                    ->where('id_study_time', $current->id)
                    ->where('id_tieu_chi', TcUtils::TIEU_CHI_NCKH_AWARD)
                    ->update([
                        'status' => AppUtils::SCORE_HOAN_THANH
                    ]);
                foreach($user_nckh as $user){
                    DB::table('personal_score') // có tham gia nckh
                        ->where('id_study_time', $current->id)
                        ->where('id_user', $user->id_user)
                        ->where('id_tieu_chi', TcUtils::TIEU_CHI_NCKH)
                        ->update([
                            'score' => DB::raw('max_score')
                        ]);
                    DB::table('personal_score') // NCkh có giải
                        ->where('id_study_time', $current->id)
                        ->where('id_user', $user->id_user)
                        ->where('id_tieu_chi', TcUtils::TIEU_CHI_NCKH_AWARD)
                        ->update([
                            'score' => $user->award != 0 ? DB::raw('max_score') : 0
                        ]);
                }
                // Tổng hợp điểm Đoàn
                DB::table('personal_score') // update trạng thái hd Đoàn
                    ->where('id_study_time', $current->id)
                    ->where('id_tieu_chi', TcUtils::TIEU_CHI_DOAN)
                    ->update([
                        'status' => AppUtils::SCORE_HOAN_THANH,
                        'score' => DB::raw('max_score'),
                    ]);
                $hd_doan_ids = DB::table('child_activities')
                    ->where('id_activity', AppUtils::HOAT_DONG_DOAN)
                    ->where('id_study_time', $current->id)
                    ->pluck('id');
                $user_chua_hoan_thanh = DB::table('user_receive_activities')
                    ->whereIn('id_child_activity', $hd_doan_ids)
                    ->whereNotIn('status', [AppUtils::STATUS_HOAN_THANH, AppUtils::STATUS_DUYET])
                    ->pluck('id_user');
                DB::table('personal_score') // update điểm hd Đoàn(chưa hoàn thành)
                    ->where('id_study_time', $current->id)
                    ->where('id_tieu_chi', TcUtils::TIEU_CHI_DOAN)
                    ->whereIn('id_user', $user_chua_hoan_thanh)
                    ->update([
                        'score' => 0,
                    ]);
            });
            $this->info('Collect last score successfully!');
            return 0;
        }
        catch(\Exception $e){
            Log::error("Error Command person score!");
            Log::error($e->getMessage(). $e->getTraceAsString());
        }
        return 0;
    }
}
