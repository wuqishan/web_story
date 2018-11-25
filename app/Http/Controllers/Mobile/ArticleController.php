<?php
namespace App\Http\Controllers\Mobile;

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
        $params['length'] = 15;
        $params['category_id'] = $request->get('category_id', 0);
        $params['title'] = $request->get('keyword', null);
        if ($request->ajax()) {

            $params['sort'] = [$request->get('orderby', 'view'), 'desc'];
            $temp = $service->get($params);
            $results['category_id'] = $params['category_id'];
            $results['books'] = $temp['list'];

            $view = 'mobile.common.section';
        } else {

            $params['sort'] = ['view', 'desc'];
            $results['books'][$params['category_id']] = $service->get($params);

            $view = 'mobile.article.index';
        }
        // 显示图文的记录数目
        $results['image_show'] = 3;

        // seo
        if ($params['category_id'] > 0) {
            $results['seo.title'] = Category::categoryMap($params['category_id']);
        } else {
            $results['seo.title'] = '搜索';
        }
//dd($results);
        return view($view, $results);
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
