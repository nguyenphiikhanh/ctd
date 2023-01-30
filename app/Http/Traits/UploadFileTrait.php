<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait{
    public function storageMultipleFile($files = [], $table, $column, $link_id, $fileFolder = 'childActFiles')
    {
        try{
            DB::beginTransaction();
            foreach($files as $file){
                $fileNameOrigin = $file->getClientOriginalName();
                $fileNameHash = Str::random(16) . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('public/' . $fileFolder .'/', $fileNameHash);
                //save file info to database
                $fileInfo = [
                    'file_name' => $fileNameOrigin,
                    'file_name_hash' => $fileNameHash,
                    'file_path' => Storage::url($filepath),
                    $column => $link_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                DB::table($table)->insert($fileInfo);
                //
            }
            DB::commit();
            return true;
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }
    }
}
