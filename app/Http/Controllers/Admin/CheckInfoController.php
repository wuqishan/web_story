<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ChapterService;
use App\Services\CheckBookInfoService;
use Illuminate\Http\Request;

class CheckInfoController extends Controller
{
    // 章节
    public function index(Request $request, CheckBookInfoService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.check_info.index', ['results' => $results]);
    }

    public function delete(Request $request, CheckBookInfoService $service)
    {
        $resutls = ['status' => false];
        $ids = $request->get('ids');
        $resutls['status'] = $service->delete($ids);

        return $resutls;
    }


    public function update(Request $request, CheckBookInfoService $service)
    {
        $resutls = ['status' => false];
        $status = intval($request->get('status'));
        $ids = $request->get('ids');
        $resutls['status'] = $service->update($ids, 'status', $status);

        return $resutls;
    }
}
