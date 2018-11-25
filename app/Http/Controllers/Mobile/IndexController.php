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
        $params = ['length' => 6];
        if ($request->ajax()) {


            $params['category_id'] = $request->get('category_id', 1);
            $params['sort'] = [$request->get('orderby', 'view'), 'desc'];
            $temp = $service->get($params);

            $results['category_id'] = $params['category_id'];
            $results['books'] = $temp['list'];

            $view = 'mobile.common.section';
        } else {
            $params['category_id'] = 1;
            $params['sort'] = ['view', 'desc'];
            $results['books'][1] = $service->get($params);

            $params['category_id'] = 2;
            $results['books'][2] = $service->get($params);

            $params['category_id'] = 3;
            $results['books'][3] = $service->get($params);

            /*
            $params['category_id'] = 4;
            $results['book'][4] = $service->get($params);

            $params['category_id'] = 5;
            $results['book'][5] = $service->get($params);

            $params['category_id'] = 6;
            $results['book'][6] = $service->get($params);

            $params['category_id'] = 7;
            $results['book'][7] = $service->get($params);
            */
            $view = 'mobile.index.index';
        }

        $results['image_show'] = 2;
        // seo
        $results['seo.title'] = '首页';

        return view($view, $results);
    }
}
