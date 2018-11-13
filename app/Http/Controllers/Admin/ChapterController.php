<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ChapterService;
use App\Services\CheckBookInfoService;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    // 章节
    public function index(Request $request, ChapterService $service, BookService $bookService/*, CheckBookInfoService $checkBookInfo*/)
    {
        $book_unique_code = $request->book_unique_code;
        $params = $request->all();
        $results['book'] = $bookService->getOne(['unique_code' => $book_unique_code]);
        $results['data'] = $service->get($results['book']['category_id'], $book_unique_code, $params);
//        $results['check_info'] = $checkBookInfo->get(['book_id' => $results['book']['id']]);

        return view('admin.chapter.index', ['results' => $results]);
    }

    public function listAll(Request $request, ChapterService $service)
    {
        $params = $request->all();
        $category_id = intval($request->get('category_id', 1));
        $results['data'] = $service->get($category_id, null, $params);
        $results['category_id'] = $category_id;

        return view('admin.chapter.list_all', ['results' => $results]);
    }

    public function update(Request $request, ChapterService $service)
    {
        $results = ['status' => false];
        if ($request->ajax()) {
            $results['status'] = (bool) $service->save($request->all());
        }

        return $results;
    }

    public function deleteAllChapter(Request $request, ChapterService $service)
    {
        $results = ['status' => false];
        $params = $request->all();
        $results['status'] = (bool) $service->deleteAllChpater($params);

        return $results;
    }
}
