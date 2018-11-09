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

    public function detail(Request $request, CheckBookInfoService $service, BookService $bookService, ChapterService $chapterService)
    {
        $check_info_id = $request->check_info_id;
        $results['detail'] = $service->getOne($check_info_id);
        $results['book'] = $bookService->getOne(['book_id' => $results['detail']['book_id']]);
        $results['data'] = $chapterService->get($results['book']['unique_code'], $results['book']['category_id']);
//dd($results);
        return view('admin.check_info.detail', ['results' => $results]);
    }

    public function methodUpdate(Request $request, CheckBookInfoService $service)
    {
        $results = ['status' => false];
        $check_info_id = $request->check_info_id;
        $method_id = $request->method_id;

        $results['status'] = (bool) $service->update($check_info_id, 'method', $method_id);

        return $results;
    }
}
