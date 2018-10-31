<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
