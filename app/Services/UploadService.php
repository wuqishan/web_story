<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadService extends Service
{
    public function commonUpload($storage, $name)
    {
        $results = [
            'status' => false,
            'data' => ['filename' => '', 'origin_name' => '', 'filepath' => '']
        ];
        // 文件是否上传成功
        if (request()->hasFile($name)) {
            $file = request()->file($name);
            if ($file->isValid()) {
                $results['data']['origin_name'] = $file->getClientOriginalName(); // 文件原名
                $results['data']['filename'] = md5($results['data']['origin_name'] . rand(1, 100000)) . date('His') . '.' . $file->getClientOriginalExtension();
                $results['data']['filepath'] = config("filesystems.disks.{$storage}.url");
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $results['status'] = Storage::disk($storage)->put($results['data']['filename'],file_get_contents($realPath));
            }
        }

        return $results;
    }
}
