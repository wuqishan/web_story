<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\BookService;
use App\Services\ChapterService;
use App\Services\FriendLinkService;
use Illuminate\Http\Request;

class ArticleController extends  Controller
{
    public function index(Request $request, BookService $service, FriendLinkService $friendLinkService)
    {
        $params['title'] = $request->get('keyword', null);
        $params['category_id'] = $request->get('category_id', 0);

        $params['sort'] = ['last_update', 'desc'];
        $results['book_update'] = $service->get($params);

        $params['sort'] = ['view', 'desc'];
        $results['book_popular'] = $service->get($params);

        // 友链
        $results['friend_link'] = $friendLinkService->get();

        // seo
        $results['seo.title'] = Category::categoryMap($request->category_id);

        return view('home.article.index', ['results' => $results]);
    }

    public function chapter(Request $request, BookService $service, ChapterService $chapterService)
    {
        $params['unique_code'] = $request->unique_code;
        $results['book'] = $service->getOne($params);

        // 显示30条每页
        $chapterService->_length = 60;
        $chapterService->_offset = ($chapterService->_page - 1) * $chapterService->_length;
        $results['chapter'] = $chapterService->get($results['book']['category_id'], $results['book']['unique_code']);

        // seo
        $results['seo.title'] = Category::categoryMap($results['book']['category_id']) . ' - ';
        $results['seo.title'] .= $results['book']['title'];

        return view('home.article.chapter', ['results' => $results]);
    }

    public function detail(Request $request, ChapterService $service, BookService $bookService)
    {
        $params['category_id'] = $request->category_id;
        $params['unique_code'] = $request->unique_code;
        $results['chapter'] = $service->getOne($params, true);
        $results['book'] = $bookService->getOne(['unique_code' => $results['chapter']['book_unique_code']]);
        // seo
        $results['seo.title'] = Category::categoryMap($results['book']['category_id']) . ' - ';
        $results['seo.title'] .= $results['book']['title'] . ' - ';
        $results['seo.title'] .= $results['chapter']['title'];

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
