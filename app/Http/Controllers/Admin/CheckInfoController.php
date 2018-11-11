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
        $id = intval($request->get('id'));
        $resutls['status'] = $service->delete($id);

        return $resutls;
    }
}
