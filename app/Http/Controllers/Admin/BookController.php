<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Services\BookService;
use App\Services\CategoryService;
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

    public function create(CategoryService $service)
    {
        $results['category'] = $service->get();

        return view('admin.book.create', ['results' => $results]);
    }

    public function store(BookRequest $request, BookService $service)
    {
        $results = ['status' => false];
        $results['status'] = (bool) $service->save($request->all());

        return $results;
    }

    public function edit(Request $request, BookService $service)
    {
        $results['detail'] = $service->getOne(['book_id' => $request->book_id]);

        return view('admin.book.edit', ['results' => $results]);
    }

    public function update(BookRequest $request, BookService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->save($params, $request->book_id);

        return $results;
    }

    public function updateFinished(BookRequest $request, BookService $service)
    {
        $book_id = intval($request->get('book_id'));
        $finished = intval($request->get('finished'));
        $results['status'] = (bool) $service->updateFinished($book_id, $finished);

        return $results;
    }

    public function destroy(Request $request, BookService $service)
    {
        $book_id = intval($request->book_id);
        $results['status'] = (bool) $service->deleteBook($book_id);

        return $results;
    }
}
