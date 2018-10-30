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

    /**
     * 编辑
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        return view('admin.goods.create');
    }

    /**
     * 保存数据
     *
     * @param GoodsRequest $request
     * @param GoodsService $service
     * @return array
     */
    public function store(GoodsRequest $request, GoodsService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->saveData($params);

        return $results;
    }

    /**
     * 编辑数据
     *
     * @param Request $request
     * @param GoodsService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, GoodsService $service)
    {
        $results['detail'] = $service->getDetail($request->goods_id);

        return view('admin.goods.edit', ['results' => $results]);
    }

    /**
     * @param GoodsRequest $request
     * @param GoodsService $service
     * @return array
     */
    public function update(GoodsRequest $request, GoodsService $service)
    {
        $params = $request->all();
        $results['status'] = (bool) $service->saveData($params, $request->goods_id);

        return $results;
    }

    /**
     * @param Request $request
     * @param GoodsService $service
     * @return array
     */
    public function destroy(Request $request, GoodsService $service)
    {
        $results['status'] = $service->delete($request->goods_id);

        return $results;
    }
}
