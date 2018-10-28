<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FilesService;
use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * 文件上传
     *      name  =>  $_FILES 里面键
     *      store =>  是否存入零时表
     * @param Request $request
     * @param UploadService $service
     * @param FilesService $filesService
     * @return array
     */
    public function upload(Request $request, UploadService $service, FilesService $filesService)
    {
        $name = $request->get('name', 'upload_file');
        $results = $service->commonUpload($name);
        $results['data']['id'] = $filesService->storeFiles($results);

        return $results;
    }

    /**
     * 附件删除
     *
     * @param Request $request
     * @param FilesService $service
     * @return array
     */
    public function delete(Request $request, FilesService $service)
    {
        $results = ['status' => false];
        $id = (int) $request->id;
        if ($id > 0) {
            $results['status'] = (bool) $service->delete($id);
        }

        return $results;
    }
}
