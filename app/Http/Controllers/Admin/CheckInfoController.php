<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
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

    public function show(Request $request, ChapterService $service, BookService $bookService)
    {
        $results = [];
        $book_id = $request->get('book_id');
        $unique_code = $request->get('unique_code');
        $category_id = $request->get('category_id');
        if (! empty($unique_code) && intval($category_id) && intval($book_id) > 0) {
            $results = $service->getOne(['category_id' => $category_id, 'unique_code' => $unique_code], true);
            $results['content'] = $service->highlightEndKeyword($results['content']);
            $results['book'] = $bookService->getOne(['book_id' => $book_id]);
        }

        return view('admin.check_info.show', ['results' => $results]);
    }
}
