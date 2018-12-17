<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookDeletedService;
use Illuminate\Http\Request;

class BookDeletedController extends Controller
{
    // 章节
    public function index(Request $request, BookDeletedService $service)
    {
        $params = $request->all();
        $results['data'] = $service->get($params);

        return view('admin.book_deleted.index', ['results' => $results]);
    }
}
