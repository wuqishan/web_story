<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // 章节
    public function index(Request $request, BookService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.book.index', ['results' => $results]);
    }
}
