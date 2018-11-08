<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\ChapterService;
use Illuminate\Http\Request;

class ArticleController extends  Controller
{
    public function index(Request $request, BookService $service)
    {
        $params['title'] = $request->get('keyword', null);
        $params['category_id'] = $request->category_id;

        $params['sort'] = ['last_update', 'desc'];
        $results['book_update'] = $service->get($params);

        $params['sort'] = ['view', 'desc'];
        $results['book_popular'] = $service->get($params);

        return view('home.article.index', ['results' => $results]);
    }

    public function chapter(Request $request, BookService $service, ChapterService $chapterService)
    {
        $params['unique_code'] = $request->unique_code;
        $results['book'] = $service->getOne($params);

        // 显示30条每页
        $chapterService->_length = 30;
        $chapterService->_offset = ($chapterService->_page - 1) * $chapterService->_length;
        $results['chapter'] = $chapterService->get($results['book']['unique_code'], $results['book']['category_id']);

        return view('home.article.chapter', ['results' => $results]);
    }

    public function detail(Request $request, ChapterService $service)
    {
        $params['category_id'] = $request->category_id;
        $params['unique_code'] = $request->unique_code;
        $results['chapter'] = $service->getOne($params, true);

        return view('home.article.detail', ['results' => $results]);
    }

    public function updateView(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $id = $request->get('id');
            $category_id = $request->get('category_id');

            if ($type == 'book') {
                (new BookService())->updateView($id);
            } else if ($type == 'chapter') {
                (new ChapterService())->updateView($id, $category_id);
            }
        }
    }
}
