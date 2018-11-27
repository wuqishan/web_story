<?php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use App\Services\FriendLinkService;
use Illuminate\Http\Request;

class IndexController extends  Controller
{
    public function index(Request $request, BookService $service, FriendLinkService $friendLinkService)
    {
        // seo
        $results['seo.title'] = '首页';

        return view('mobile.index.index', $results);
    }

    public function bookList(Request $request, BookService $service)
    {
        $params['length'] = 6;
        $params['category_id'] = $request->get('category_id', 1);
        $params['sort'] = [$request->get('orderby', 'view'), 'desc'];
        $results = $service->get($params);

        $results['books'] = $results['list'];
        $results['sort'] = $params['sort'][0];
        $results['category_id'] = $params['category_id'];
        $results['image_show'] = 2;
        unset($results['list']);

        return view('mobile.common.book_show', $results);
    }

    public function moreBook(Request $request)
    {
        $params['page'] = $request->get('page', 1) + 1;
        $params['length'] = $request->get('length', 1);
        $params['category_id'] = $request->get('category_id', 1);
        $params['orderby'] = $request->get('orderby', 1);


    }
}
