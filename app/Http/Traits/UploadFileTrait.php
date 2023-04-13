<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait{
    public function storageMultipleFile($files = [], $table, $column, $link_id, $fileFolder = 'childActFiles')
    {
        try{
            DB::connection('mysql')->beginTransaction();
            $oldFiles = DB::table($table)->where($column, $link_id)->get();
            foreach($oldFiles as $delFile){
                $del_path = public_path($delFile->file_path);
                if(File::exists($del_path)){
                    unlink($del_path);
                }
            }
            DB::table($table)->where($column, $link_id)->delete();
            foreach($files as $file){
                $fileNameOrigin = $file->getClientOriginalName();
                $fileNameHash = Str::random(16) . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('public/' . $fileFolder , $fileNameHash);
                //save file info to database
                $fileInfo = [
                    'file_name' => $fileNameOrigin,
                    'file_name_hash' => $fileNameHash,
                    'file_path' => Storage::url($filepath),
                    $column => $link_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $file->move('storage/' . $fileFolder , $fileNameHash);
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
