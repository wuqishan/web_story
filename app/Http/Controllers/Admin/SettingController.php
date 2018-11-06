<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Services\UploadService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Banner
    public function banner(Request $request, SettingService $service, UploadService $uploadService)
    {
        if ($request->isMethod('get')) {

            $results['data']['list'] = $service->getByName('banner');

            return view('admin.setting.banner', ['results' => $results]);

        } else if ($request->isMethod('post')) {

            $id = $request->get('id', 0);
            $data['orderby'] = $request->get('orderby');
            $data['name'] = $request->get('name');
            $upload = $uploadService->commonUpload('banner', 'value');
            if (! empty($upload['data']['filepath']) && ! empty($upload['data']['filename'])) {
                $data['value'] = $upload['data']['filepath'] . $upload['data']['filename'];
            }
            $results['status'] = (bool) $service->save($data, $id);

            return $results;
        }
    }

    // Logo
    public function logo(Request $request, SettingService $service, UploadService $uploadService)
    {
        if ($request->isMethod('get')) {
            $logo = $service->getByName('logo');
            if (! empty($logo)) {
                $logo = array_pop($logo);
            }
            $results['data'] = (array) $logo;

            return view('admin.setting.logo', ['results' => $results]);

        } else if ($request->isMethod('post')) {
            $results['status'] = false;
            $id = $request->get('id', 0);
            $data['name'] = $request->get('name');
            $upload = $uploadService->commonUpload('logo', 'value');

            // 如果id大于0，则先删除之前记录再做插入
            if ($id > 0) {
                $service->delete($id, true);
            }

            if (! empty($upload['data']['filepath']) && ! empty($upload['data']['filename'])) {
                $data['value'] = $upload['data']['filepath'] . $upload['data']['filename'];
                $results['status'] = (bool) $service->save($data, 0);
            }

            return $results;
        }
    }

    public function delete(Request $request, SettingService $service)
    {
        $id = $request->get('id');
        $del_image = $request->get('del_image', false);
        $results['status'] = (bool) $service->delete($id, $del_image);

        return $results;
    }
}
