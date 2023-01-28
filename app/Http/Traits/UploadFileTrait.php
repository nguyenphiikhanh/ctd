<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait{
    public function storageMultipleFile($files = [], $id_childActivity)
    {
        foreach($files as $file){
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $filepath = $file->storeAs('public/clientFiles/', $fileNameHash);
            //save file info to database
            $fileInfo = [
                'file_name' => $fileNameOrigin,
                'file_path' => Storage::url($filepath),
                'id_child_activity' => $id_childActivity,
            ];
            //
        }
    }
}
