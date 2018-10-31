<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ChapterService;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    // 章节
    public function index(Request $request, ChapterService $service, BookService $bookService)
    {
        $book_unique_code = $request->book_unique_code;
        $params = $request->all();
        $results['book'] = $bookService->getOne(['unique_code' => $book_unique_code]);
        $results['data'] = $service->get($book_unique_code, $results['book']['category_id'], $params);

        return view('admin.chapter.index', ['results' => $results]);
    }
}
