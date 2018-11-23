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

        $view = '';
        if ($request->ajax()) {

        } else {
            $params = ['category_id' => 1, 'sort' => ['view', 'desc']];
            $results['book'][1] = $service->get($params);
            $params = ['category_id' => 2, 'sort' => ['view', 'desc']];
            $results['book'][2] = $service->get($params);
            $view = 'mobile.index.index';
        }

        // seo
        $results['seo.title'] = '首页';
dd($results);
        return view($view, ['results' => $results]);
    }
}
