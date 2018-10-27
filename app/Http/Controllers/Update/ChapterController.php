<?php
namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ChapterService;
use App\Services\CheckBookInfoService;
use Illuminate\Http\Request;

class ChapterController extends  Controller
{
    public function index(Request $request, ChapterService $service, BookService $bookService, CheckBookInfoService $checkBookInfoService)
    {
        $id = $request->get('id');
        $uniqueCode = $request->get('book_unique_code');
        $params['book_unique_code'] = $uniqueCode;
        $sort = ['orderby', 'asc'];
        $select = [
            'book_unique_code',
            'unique_code',
            'prev_unique_code',
            'next_unique_code',
            'title',
            'url',
            'orderby'
        ];
        $results['data'] = $service->get($params, $sort, 0, $select);
        $results['book'] = $bookService->getOne(['unique_code' => $uniqueCode]);
        $results['bookCheck'] = $checkBookInfoService->getOne(['id' => $id]);

        return view('update.chapter.index', ['results' => $results]);
    }

    public function updateMethod(Request $request, CheckBookInfoService $service)
    {
        $method = (int) $request->get('method', 0);
        $id = (int) $request->get('id', 0);

        $service->update($id, 'method', $method);

        return redirect()->route('update-book-index');
    }
}
