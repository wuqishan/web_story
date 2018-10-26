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
        $params['category_id'] = $request->category_id;
        $results['book_update'] = $service->get($params, ['last_update', 'desc'], 20);
        $results['book_popular'] = $service->get($params, ['view', 'desc'], 15);

        return view('home.article.index', ['results' => $results]);
    }

    public function chapter(Request $request, BookService $service, ChapterService $chapterService)
    {
        $params['unique_code'] = $request->unique_code;
        $results['book'] = $service->getOne($params);
        $results['chapter'] = $chapterService->get(
            ['book_unique_code' => $results['book']['unique_code']],
            ['orderby', 'asc'],
            0,
            ['title', 'unique_code']
        );

        return view('home.article.chapter', ['results' => $results]);
    }

    public function detail(Request $request, ChapterService $service)
    {
        $params['unique_code'] = $request->unique_code;
        $results['chapter'] = $service->getOne($params);

        return view('home.article.detail', ['results' => $results]);
    }

    public function updateView(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $id = $request->get('id');
            if ($type == 'book') {
                (new BookService())->updateView($id);
            } else if ($type == 'chapter') {
                (new ChapterService())->updateView($id);
            }
        }
    }
}
